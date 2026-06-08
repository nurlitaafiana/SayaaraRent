<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RentalService;
use App\Models\Kategori;
use App\Http\Requests\StoreRentalRequest;
use App\Models\Kendaraan;

class RentalController extends Controller
{
    public function __construct(
        protected RentalService $rentalService
    ) {}

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $rentals = $this->rentalService->getAllRentals();
            return view('admin.rental', compact('rentals'));
        }

        $rentals = $this->rentalService->getActiveRentalsByUser(auth()->id());
        return view('customer.rental.index', compact('rentals'));
    }

    public function create(Request $request)
    {
        $kendaraans  = Kendaraan::where('status', 'tersedia')->get();
        $kendaraan   = $request->kendaraan_id
                        ? Kendaraan::find($request->kendaraan_id)
                        : null;
        $bookedDates = $kendaraan
                        ? $this->rentalService->getBookedDatesByKendaraan($kendaraan->id)
                        : [];

        return view('customer.rental.create', compact('kendaraans', 'kendaraan', 'bookedDates'));
    }

    public function store(StoreRentalRequest $request)
    {
        $result = $this->rentalService->handleStoreRental(
            $request->validated(),
            auth()->id(),
            $request->file('upload_ktp'),
            $request->file('upload_sim')
        );

        if (!$result['tersedia']) {
            return back()
                ->withInput()
                ->withErrors(['tanggal_mulai' => 'Kendaraan sudah dibooking pada tanggal tersebut.']);
        }

        return redirect()
            ->route('customer.rental.index')
            ->with('success', 'Booking berhasil! Menunggu verifikasi admin.');
    }

    public function verify($id)
    {
        $this->rentalService->verifyRental($id);
        return redirect()->back()->with('success', 'Rental berhasil diverifikasi dan menunggu pembayaran.');
    }

    public function reject(Request $request, $id)
    {
        $this->rentalService->rejectRental($id, $request->catatan_admin);
        return redirect()->back()->with('success', 'Rental berhasil ditolak.');
    }

    public function cancel($id)
    {
        $this->rentalService->cancelRental($id);
        return redirect()->back()->with('success', 'Rental berhasil dibatalkan.');
    }

    public function complete($id)
    {
        $this->rentalService->completeRental($id);
        return redirect()->back()->with('success', 'Rental telah selesai.');
    }

    public function customerDashboard()
    {
        $user = auth()->user();

        return view('customer.dashboard', [
            'totalRental'    => $user->rentals()->count(),
            'activeRental'   => $user->rentals()->where('status', 'active')->count(),
            'pendingPayment' => $user->rentals()->where('status', 'waiting_payment')->count(),
            'kategoris'      => Kategori::with(['kendaraans' => fn($q) => $q->where('status', 'tersedia')])->get(),
        ]);
    }

    public function history(Request $request)
    {
        $rentals = $this->rentalService->getRentalsByUser(auth()->id(), $request->status);
        return view('customer.rental.history', compact('rentals'));
    }
}