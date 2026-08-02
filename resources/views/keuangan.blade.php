@extends('layouts.app')

@section('title', 'Laporan Keuangan Kas - Masjid Nurul Ikhlas Pekanbaru')

@section('content')
<!-- HEADER SECTION -->
<div class="bg-emerald-800 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <span class="text-emerald-300 text-xs font-bold uppercase tracking-widest block mb-2">Transparansi Umat</span>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Laporan Keuangan Kas Masjid</h1>
        <p class="text-emerald-100 text-sm max-w-2xl mx-auto leading-relaxed">
            Laporan transparansi pemasukan dan pengeluaran kas Masjid Nurul Ikhlas Pekanbaru secara akuntabel.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- SUMMARY SALDO -->
        <div class="grid md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <span class="text-xs text-slate-400 block mb-1">Kas Operasional</span>
                <span class="text-xl font-bold text-slate-900 block">Rp {{ number_format($kasOperasional, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <span class="text-xs text-slate-400 block mb-1">Kas Pembangunan</span>
                <span class="text-xl font-bold text-slate-900 block">Rp {{ number_format($kasPembangunan, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <span class="text-xs text-slate-400 block mb-1">Kas Anak Yatim</span>
                <span class="text-xl font-bold text-slate-900 block">Rp {{ number_format($kasYatim, 0, ',', '.') }}</span>
            </div>
            <div class="bg-emerald-600 text-white p-5 rounded-2xl shadow-sm">
                <span class="text-xs text-emerald-100 block mb-1">Total Seluruh Kas</span>
                <span class="text-xl font-extrabold block">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- TABEL RIWAYAT TRANSAKSI -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h2 class="font-bold text-slate-900 text-lg">Catatan Transaksi Terakhir</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $report->category }}
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $report->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($report->type === 'income')
                                        <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-semibold">📥 Pemasukan</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full text-xs font-semibold">📤 Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-bold whitespace-nowrap {{ $report->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $report->type === 'income' ? '+' : '-' }} Rp {{ number_format($report->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada riwayat transaksi kas dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $reports->links() }}
            </div>
        </div>

    </div>
</div>
@endsection