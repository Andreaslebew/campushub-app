@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <h1 class="text-xl font-bold text-neutral-900">Panel Admin</h1>
    @include('admin._menu')

    <div class="flex flex-wrap gap-2">
        @foreach (['menunggu' => 'Menunggu', 'ditindak' => 'Ditindak', 'diabaikan' => 'Diabaikan'] as $nilai => $label)
            <a href="{{ route('admin.laporan', ['status' => $nilai]) }}"
                class="rounded-full px-3 py-1 text-xs font-semibold
                {{ $status === $nilai ? 'bg-neutral-900 text-white' : 'border border-neutral-300 text-neutral-600' }}">
                {{ $label }} ({{ $ringkasan[$nilai] ?? 0 }})
            </a>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse ($laporan as $item)
            @include('admin._kartu-laporan', ['laporan' => $item])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-6 text-center text-sm text-neutral-500">
                Tidak ada laporan dengan status ini.
            </div>
        @endforelse
    </div>

    {{ $laporan->links() }}
</div>
@endsection