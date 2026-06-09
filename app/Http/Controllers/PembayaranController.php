<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PembayaranService;
use App\Http\Requests\StorePembayaranRequest;

class PembayaranController extends Controller
{
    public function __construct(
        protected PembayaranService $pembayaranService
    ) {}

    public function index()
    {
        $payments = $this->pembayaranService->getUserPayments(auth()->id());

        return view('customer.pembayaran.index', compact('payments'));
    }

    public function create($rental_id)
    {
        return view('customer.pembayaran.create', compact('rental_id'));
    }

    public function store(StorePembayaranRequest $request)
    {
        $data = $request->validated();

        $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')
            ->store('pembayaran', 'public');

        $this->pembayaranService->createPembayaran($data);

        return back()->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi admin');
    }

    public function show($id)
    {
        $payment = $this->pembayaranService->getPaymentById($id);

        if (!$payment) {
            abort(404);
        }

        return view('pembayaran.show', compact('payment'));
    }

    public function adminIndex()
    {
        $payments = $this->pembayaranService->getAllPayments(); // ganti ini
        return view('admin.pembayaran.index', compact('payments'));
    }

    public function verifiedPayments()
    {
        $payments = $this->pembayaranService->getVerifiedPayments();

        return view('admin.pembayaran.verified', compact('payments'));
    }

    public function verifyPayment($id)
    {
        $this->pembayaranService->verifyPayment($id);

        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function rejectPayment(Request $request, $id)
    {
        $this->pembayaranService->rejectPayment($id, $request->catatan_admin);

        return back()->with('success', 'Pembayaran berhasil ditolak');
    }

    
}