<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKendaraanRequest;
use App\Services\KendaraanService;
use App\Services\RentalService;
use App\Models\Kategori;

class KendaraanController extends Controller
{
    public function __construct(
        protected KendaraanService $kendaraanService,
        protected RentalService $rentalService
    ) {}

    public function index()
    {
        $kendaraans = $this->kendaraanService->getAllKendaraans();
        return view('admin.kendaraan', compact('kendaraans'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.kendaraan.create', compact('kategoris'));
    }

    public function store(StoreKendaraanRequest $request)
    {
        $this->kendaraanService->createKendaraan(
            $request->validated(),
            $request->file('gambar')
        );
        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $kendaraan = $this->kendaraanService->findKendaraanById($id);
        return view('admin.kendaraan.show', compact('kendaraan'));
    }

    public function edit(int $id)
    {
        $kendaraan = $this->kendaraanService->findKendaraanById($id);
        $kategoris = Kategori::all();
        return view('admin.kendaraan.edit', compact('kendaraan', 'kategoris'));
    }

    public function update(StoreKendaraanRequest $request, int $id)
    {
        $this->kendaraanService->updateKendaraan(
            $id,
            $request->validated(),
            $request->file('gambar')
        );
        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diupdate');
    }

    public function destroy(int $id)
    {
        $this->kendaraanService->deleteKendaraan($id);
        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus');
    }

    public function byKategori(int $kategoriId)
    {
        $kendaraans = $this->kendaraanService->getKendaraansByKategori($kategoriId);
        return view('admin.kendaraan.by-kategori', compact('kendaraans'));
    }

    public function available()
    {
        $kategoris       = $this->kendaraanService->getKendaraansByKategoriForCustomer();
        $bookedDatesMap  = [];
        $bookedRangesMap = [];

        foreach ($kategoris as $kategori) {
            foreach ($kategori->kendaraans as $kendaraan) {
                $bookedDatesMap[$kendaraan->id]  = $this->rentalService->getBookedDatesByKendaraan($kendaraan->id);
                $bookedRangesMap[$kendaraan->id] = $this->rentalService->getBookedRangesByKendaraan($kendaraan->id);
            }
        }

        return view('customer.kendaraan.index', compact('kategoris', 'bookedDatesMap', 'bookedRangesMap'));
    }
}