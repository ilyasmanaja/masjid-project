@extends('layouts.app')

@section('title', 'Jadwal Kajian & Agenda - Masjid Nurul Ikhlas')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">

    <!-- HEADER SECTION -->
    <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold uppercase tracking-wider">
            Agenda Masjid
        </span>
        <h2 class="text-3xl font-bold text-slate-900 mt-3 mb-2">Jadwal Kajian & Kegiatan</h2>
        <p class="text-slate-600 text-sm">
            Ikuti berbagai kegiatan ibadah, kajian keilmuan, dan agenda sosial di Masjid Nurul Ikhlas Pekanbaru.
        </p>
    </div>

    <!-- SECTION 1: KAJIAN & KEGIATAN RUTIN -->
    <div class="mb-16">
        <div class="flex items-center gap-3 mb-6 border-b border-slate-200 pb-3">
            <span class="text-2xl">🔄</span>
            <div>
                <h3 class="text-xl font-bold text-slate-900">Kajian & Program Rutin Pekanan</h3>
                <p class="text-xs text-slate-500">Berlangsung secara berkala setiap pekan/hari</p>
            </div>
        </div>

        @if($rutinEvents->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rutinEvents as $event)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg border border-emerald-200">
                                    {{ $event->routine_day }}
                                </span>
                                <span class="text-xs text-slate-400">Rutin</span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-lg mb-2">{{ $event->title }}</h4>
                            @if($event->speaker)
                                <p class="text-sm text-slate-600 flex items-center gap-2 mb-2">
                                    <span>👤</span> {{ $event->speaker }}
                                </p>
                            @endif
                            <p class="text-xs text-slate-500 flex items-center gap-2">
                                <span>📍</span> {{ $event->location }}
                            </p>
                            @if($event->description)
                                <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-slate-100 line-clamp-2">
                                    {{ $event->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-slate-100 rounded-2xl text-slate-500 text-sm">
                Belum ada jadwal kajian rutin yang dimasukkan.
            </div>
        @endif
    </div>

    <!-- SECTION 2: ACARA INSIDENTAL / MENDATANG -->
    <div>
        <div class="flex items-center gap-3 mb-6 border-b border-slate-200 pb-3">
            <span class="text-2xl">📅</span>
            <div>
                <h3 class="text-xl font-bold text-slate-900">Acara & Agenda Mendatang</h3>
                <p class="text-xs text-slate-500">Kegiatan temporer, gotong royong, atau peringatan hari besar</p>
            </div>
        </div>

        @if($insidentalEvents->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($insidentalEvents as $event)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-lg border border-amber-200">
                                        {{ $event->event_date ? $event->event_date->translatedFormat('d M Y, H:i') . ' WIB' : 'Segera' }}
                                    </span>
                                    <span class="text-xs text-slate-400">Insidental</span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-lg mb-2">{{ $event->title }}</h4>
                                @if($event->speaker)
                                    <p class="text-sm text-slate-600 flex items-center gap-2 mb-2">
                                        <span>👤</span> {{ $event->speaker }}
                                    </p>
                                @endif
                                <p class="text-xs text-slate-500 flex items-center gap-2">
                                    <span>📍</span> {{ $event->location }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-slate-100 rounded-2xl text-slate-500 text-sm">
                Belum ada agenda insidental mendatang.
            </div>
        @endif
    </div>

</div>
@endsection