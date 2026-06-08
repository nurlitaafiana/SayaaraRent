<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailRentalRequest;
use App\Services\DetailRentalService;

class DetailRentalController extends Controller
{
    public function __construct(
        protected DetailRentalService $detailRentalService
    ) {}

    /*
    |--------------------------
    | CUSTOMER
    |--------------------------
    */

    public function index($rentalId)
    {
        $details = $this->detailRentalService->findByRentalId($rentalId);

        return view('customer.detail-rental.index', compact('details'));
    }

    public function show($id)
    {
        $detail = $this->detailRentalService->findByRentalId($id);

        if (!$detail) {
            abort(404);
        }

        return view('customer.detail-rental.show', compact('detail'));
    }

    /*
    |--------------------------
    | ADMIN
    |--------------------------
    */

    public function adminIndex($rentalId)
    {
        $details = $this->detailRentalService->findByRentalId($rentalId);

        return view('admin.detail-rental.index', compact('details'));
    }

    public function adminShow($id)
    {
        $detail = $this->detailRentalService->findById($id);

        if (!$detail) {
            abort(404);
        }

        return view('admin.detail-rental.show', compact('detail'));
    }

    public function store(StoreDetailRentalRequest $request)
    {
        $data = $request->validate([
            'rental_id' => 'required|integer',
            'kendaraan_id' => 'required|integer',
            'harga_per_hari' => 'required|numeric',
            'jumlah_hari' => 'required|integer',
        ]);

        $detail = $this->detailRentalService->createDetailRental($data);

        return redirect()
            ->back()
            ->with('success', 'Detail rental berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $this->detailRentalService->deleteDetailRental($id);

        return back()->with('success', 'Detail rental berhasil dihapus');
    }
}