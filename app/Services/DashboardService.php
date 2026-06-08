<?php

namespace App\Services;

use App\Models\Rental;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getAdminData(): array
    {
        return [
            'totalRental'          => $this->totalRental(),
            'pendingRental'        => $this->pendingRental(),
            'waitingPayment'       => $this->waitingPayment(),
            'activeRental'         => $this->activeRental(),
            'completedRental'      => $this->completedRental(),
            'mobilTersedia'        => $this->mobilTersedia(),
            'recentPendingRentals' => $this->recentPendingRentals(),
            'recentPayments'       => $this->recentPayments(),
            'bulanLabel'           => $this->bulanLabel(),
            'dataRental'           => $this->dataRentalPerBulan(),
            'dataPendapatan'       => $this->dataPendapatanPerBulan(),
            'pctRental'            => $this->pctRentalBulanIni(),
            'pctPendapatan'        => $this->pctPendapatanBulanIni(),
        ];
    }

    private function totalRental(): int
    {
        return Rental::count();
    }

    private function pendingRental(): int
    {
        return Rental::where('status', 'pending_verification')->count();
    }

    private function waitingPayment(): int
    {
        return Pembayaran::where('status_pembayaran', 'pending')->count();
    }

    private function activeRental(): int
    {
        return Rental::where('status', 'active')->count();
    }

    private function completedRental(): int
    {
        return Rental::where('status', 'completed')->count();
    }

    private function mobilTersedia(): int
    {
        return Kendaraan::where('status', 'tersedia')->count();
    }

    private function recentPendingRentals()
    {
        return Rental::with('user')
            ->where('status', 'pending_verification')
            ->latest()
            ->take(5)
            ->get();
    }

    private function recentPayments()
    {
        return Pembayaran::with(['rental.user'])
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->take(5)
            ->get();
    }

    private function bulanLabel(): string
    {
        return json_encode(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des']);
    }

    private function dataRentalPerBulan(): string
    {
        $data = Rental::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data->get($i)?->total ?? 0;
        }

        return json_encode($result);
    }

    private function dataPendapatanPerBulan(): string
    {
        $data = Pembayaran::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(jumlah_bayar) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->where('status_pembayaran', 'verified')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data->get($i)?->total ?? 0;
        }

        return json_encode($result);
    }

    // Persentase rental bulan ini vs bulan lalu
    private function pctRentalBulanIni(): array
    {
        $bulanIni  = Rental::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('n'))->count();
        $bulanLalu = Rental::whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('n') - 1)->count();

        $pct = $bulanLalu > 0
            ? round((($bulanIni - $bulanLalu) / $bulanLalu) * 100, 1)
            : ($bulanIni > 0 ? 100 : 0);

        return ['nilai' => $bulanIni, 'pct' => $pct, 'naik' => $pct >= 0];
    }

    // Persentase pendapatan bulan ini vs bulan lalu
    private function pctPendapatanBulanIni(): array
    {
        $bulanIni  = Pembayaran::where('status_pembayaran', 'verified')
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('n'))
                        ->sum('jumlah_bayar');

        $bulanLalu = Pembayaran::where('status_pembayaran', 'verified')
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('n') - 1)
                        ->sum('jumlah_bayar');

        $pct = $bulanLalu > 0
            ? round((($bulanIni - $bulanLalu) / $bulanLalu) * 100, 1)
            : ($bulanIni > 0 ? 100 : 0);

        return ['nilai' => $bulanIni, 'pct' => $pct, 'naik' => $pct >= 0];
    }

    public function getCustomerData(int $userId): array
    {
        $user = \App\Models\User::find($userId);

        return [
            'totalRental'    => $user->rentals()->count(),
            'activeRental'   => $user->rentals()->where('status', 'active')->count(),
            'pendingPayment' => $user->rentals()->where('status', 'waiting_payment')->count(),
            'kategoris'      => Kategori::with(['kendaraans' => fn($q) => $q->where('status','tersedia')])->get(),
        ];
    }
}