<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KategoriService;

class KategoriController extends Controller
{
    public function __construct(
        protected KategoriService $kategoriService
    ) {}

    public function index()
    {
        $kategoris = $this->kategoriService->getAllKategori();

        return view('admin.kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $this->kategoriService->createKategori(
            $request->all()
        );

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->kategoriService->updateKategori(
            $id,
            $request->all()
        );

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->kategoriService->deleteKategori($id);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}