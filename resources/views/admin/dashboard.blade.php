@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <h1 class="text-xl font-bold text-neutral-900">Panel Admin</h1>
    @include('admin._menu')

    <div class="grid grid-cols-3 gap-3">
        <div class="rounded-2xl border border-neutral-200 bg-white p-4">
            <p class="text-xs text-neutral-500">Pengguna</p>
            <p class="mt-1 text-2xl font-bold">{{ $jumlahPengguna }}</p>
        </div>
        <div class="rounded-2xl border border-neutral-200 bg-white p-4">
            <p class="text-xs text-neutral-500">Postingan</p>
            <p class="mt-1 text-2xl font-bold">{{ $jumlahPostingan }}</p>
        </div>
        <div class="rounded-2xl border p-4 {{ $laporanMenunggu > 0 ? 'border-rose-200 bg-rose-50' : 'border-neutral-200 bg-white' }}">
            <p class="text-xs text-neutral-500">Laporan menunggu</p>
            <p class="mt-1 text-2xl font-bold {{ $laporanMenunggu > 0 ? 'text-rose-600' : '' }}">{{ $laporanMenunggu }}</p>
        </div>
    </div>

    <section class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold text-neutral-900">Laporan terbaru</h2>
            <a href="{{ route('admin.laporan') }}" class="text-sm text-neutral-600 hover:underline">Lihat semua</a>
        </div>

        @forelse ($laporanTerbaru as $laporan)
            @include('admin._kartu-laporan', ['laporan' => $laporan])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-6 text-center text-sm text-neutral-500">
                Tidak ada laporan yang menunggu tinjauan.
            </div>
        @endforelse
    </section>
</div>
@endsection