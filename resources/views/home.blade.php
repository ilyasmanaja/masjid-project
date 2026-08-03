@extends('layouts.app')

@section('title', 'Masjid Nurul Ikhlas - Pekanbaru')

@section('content')

    <!-- HERO SECTION + FLOATING JADWAL SHOLAT -->
    <section class="relative bg-slate-900 text-white pt-20 md:pt-28 pb-16 overflow-hidden">
        <!-- Foto Background Utama -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/masjid.jpeg') }}" alt="Masjid Nurul Ikhlas"
                class="w-full h-full object-cover object-center">
            <!-- Overlay Gradient Gelap -->
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-900/85 to-slate-950/95"></div>
        </div>

        <!-- Konten Utama (Teks + Kartu) -->
        <div class="relative z-10 max-w-5xl mx-auto px-4">
            <!-- Teks Sambutan -->
            <div class="text-center max-w-4xl mx-auto mb-12">
                <span
                    class="inline-block px-4 py-1.5 bg-emerald-500/20 backdrop-blur-md text-emerald-300 rounded-full text-xs font-semibold tracking-wide uppercase mb-4 border border-emerald-500/30">
                    Selamat Datang di Web Resmi
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                    Masjid Nurul Ikhlas Pekanbaru
                </h1>
                <p class="text-base md:text-lg text-slate-200 max-w-2xl mx-auto leading-relaxed mb-8 drop-shadow">
                    Pusat ibadah, dakwah, dan pembinaan umat yang transparan, ramah, dan menguatkan ukhuwah islamiyah.
                </p>
                <div class="flex items-center justify-center gap-4">
                    <a href="#kas"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-full text-sm font-semibold transition shadow-lg shadow-emerald-900/50">
                        Laporan Kas Umat
                    </a>
                    <a href="{{ route('profil') }}"
                        class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/20 px-6 py-3 rounded-full text-sm font-semibold transition">
                        Profil & DKM
                    </a>
                </div>
            </div>

            <!-- KARTU JADWAL SHOLAT (FLOATING DI ATAS BACKGROUND MASJID) -->
            <!-- KARTU JADWAL SHOLAT INTERAKTIF (FLOATING DI ATAS BACKGROUND MASJID) -->
            @if (isset($prayerData) && $prayerData)
                <div id="jadwal"
                    class="bg-white/95 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-2xl shadow-black/40 border border-white/20 text-slate-800">

                    <!-- HEADER BAR: WAKTU LOKAL + BADGE IMSAK/IFTAR -->
                    <div
                        class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-200/60">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                <span>Jadwal Sholat Hari Ini</span>
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            </h2>
                            <p class="text-sm text-slate-500">
                                Pekanbaru & Sekitarnya ({{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }})
                            </p>
                        </div>

                        <!-- BADGE IMSAK & IFTAR -->
                        <div
                            class="bg-purple-950 text-white px-5 py-2 rounded-full text-xs font-medium tracking-wide shadow-sm flex items-center gap-2">
                            <span>🌙 Imsak <strong class="text-purple-200">{{ $prayerData['imsak'] }}</strong></span>
                            <span class="text-purple-400">|</span>
                            <span>🌅 Iftar <strong class="text-purple-200">{{ $prayerData['maghrib'] }}</strong></span>
                        </div>
                    </div>

                    <!-- CARDS JADWAL SHOLAT (5 WAKTU) -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3.5">
                        @foreach ($prayerData['list'] as $key => $prayer)
                            @php
                                $isCurrent = $prayerData['current'] === $key;
                                $isNext = $prayerData['next'] === $key;

                                // Highlight hijau diberikan ke 'NOW', atau ke 'NEXT' jika tidak ada sholat yang 'NOW'
                                $isHighlighted = $isCurrent || (!$prayerData['current'] && $isNext);
                            @endphp

                            <div
                                class="relative rounded-2xl p-4 md:p-5 transition-all duration-300 {{ $isHighlighted ? 'bg-white border-4 border-emerald-500 shadow-xl scale-105 z-10' : 'bg-slate-100/80 hover:bg-emerald-50/50 border border-slate-200/60' }}">

                                <!-- BADGE "NOW" ATAU "NEXT" -->
                                @if ($isCurrent)
                                    <span
                                        class="absolute top-2.5 left-2.5 bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                                        Now
                                    </span>
                                @elseif(!$prayerData['current'] && $isNext)
                                    <span
                                        class="absolute top-2.5 left-2.5 bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                                        Next
                                    </span>
                                @endif

                                <div class="{{ $isHighlighted ? 'mt-3' : '' }}">
                                    <div
                                        class="flex items-center justify-between text-slate-600 font-bold text-xs md:text-sm mb-1">
                                        <span>{{ $prayer['name'] }}</span>
                                        <span class="text-sm">{{ $prayer['icon'] }}</span>
                                    </div>

                                    <div class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">
                                        {{ $prayer['time'] }}
                                    </div>

                                    @if ($isNext)
                                        <p
                                            class="text-[11px] text-emerald-600 font-semibold mt-2 pt-1.5 border-t border-slate-200/60">
                                            ⏱️ {{ $prayerData['countdown'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- LAPORAN KEUANGAN KAS -->
    <section id="kas" class="py-16 bg-white border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">
                        Transparansi saldo kas
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Laporan Saldo Kas Masjid</h2>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 px-5 py-3 rounded-2xl">
                    <span class="text-xs text-emerald-700 font-medium block">Total Seluruh Kas Tersedia</span>
                    <span class="text-2xl font-extrabold text-emerald-800">
                        Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- GRID 3 KATEGORI KAS -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Kas Operasional -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg">🕌</span>
                        <span class="text-sm font-bold text-slate-700">Kas Operasional</span>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 block mb-1">
                        Rp {{ number_format($kasOperasional, 0, ',', '.') }}
                    </span>
                    <p class="text-xs text-slate-500">Listrik, kebersihan, & operasional harian.</p>
                </div>

                <!-- Kas Pembangunan -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg">🏗️</span>
                        <span class="text-sm font-bold text-slate-700">Kas Pembangunan</span>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 block mb-1">
                        Rp {{ number_format($kasPembangunan, 0, ',', '.') }}
                    </span>
                    <p class="text-xs text-slate-500">Renovasi & perawatan fisik masjid.</p>
                </div>

                <!-- Kas Anak Yatim -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg">👶</span>
                        <span class="text-sm font-bold text-slate-700">Kas Anak Yatim</span>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 block mb-1">
                        Rp {{ number_format($kasYatim, 0, ',', '.') }}
                    </span>
                    <p class="text-xs text-slate-500">Santunan rutin anak yatim & dhuafa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- AGENDA KAJIAN & KEGIATAN TERDEKAT -->
    <section id="kajian" class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">
                        Agenda Dakwah & Kegiatan
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Jadwal & Agenda Terdekat</h2>
                </div>
                <a href="{{ route('kajian') }}"
                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    Lihat Semua Jadwal →
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div
                        class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- BADGE WAKTU DINAMIS (RUTIN VS INSIDENTAL) -->
                            <div class="flex items-center justify-between mb-4">
                                @if ($event->type === 'rutin')
                                    <span
                                        class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                                        🔄 {{ $event->routine_day }}
                                    </span>
                                    <span
                                        class="text-[10px] uppercase font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">Rutin</span>
                                @else
                                    <span
                                        class="text-xs font-semibold text-amber-700 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                                        🗓️
                                        {{ $event->event_date ? $event->event_date->translatedFormat('d M Y - H:i') . ' WIB' : 'Segera' }}
                                    </span>
                                    <span
                                        class="text-[10px] uppercase font-bold text-amber-600 bg-amber-100 px-2 py-0.5 rounded">Agenda</span>
                                @endif
                            </div>

                            <!-- JUDUL KEGIATAN -->
                            <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $event->title }}</h3>

                            <!-- PENCERAMAH / PJ (TAMPIL HANYA JIKA ADA) -->
                            @if ($event->speaker)
                                <p class="text-xs text-slate-600 mb-3">
                                    🎙️ <strong>Pengisi:</strong> {{ $event->speaker }}
                                </p>
                            @endif
                        </div>

                        <!-- LOKASI KEGIATAN -->
                        <div
                            class="text-xs text-slate-400 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span>📍 {{ $event->location }}</span>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400 text-sm">
                        Belum ada jadwal kajian atau agenda terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- STRUKTUR PENGURUS -->
    <section id="pengurus" class="py-16 bg-white border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">
                        Struktur DKM
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Pengurus Masjid</h2>
                </div>
                <a href="{{ route('profil') }}"
                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    Selengkapnya di Profil →
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($boardMembers as $member)
                    <div class="bg-slate-50 rounded-2xl p-5 text-center border border-slate-100 shadow-sm">
                        <div
                            class="w-20 h-20 mx-auto rounded-full overflow-hidden bg-slate-200 mb-4 flex items-center justify-center font-bold text-xl text-slate-500">
                            @if ($member->photo)
                                <img src="{{ url('/uploads/' . $member->photo) }}" alt="{{ $member->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr($member->name, 0, 1) }}
                            @endif
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm mb-1 line-clamp-2">{{ $member->name }}</h3>
                        <p class="text-xs text-emerald-600 font-medium">{{ $member->position }}</p>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-8 text-slate-400 text-sm">
                        Data pengurus belum diinput.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- BERITA TERBARU -->
    <section id="berita" class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">
                        Informasi Terkini
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Berita & Kegiatan</h2>
                </div>
                <a href="{{ route('posts.index') }}"
                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    Lihat Semua Berita →
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition group flex flex-col">
                        <div class="h-48 bg-slate-100 overflow-hidden">
                            @if ($post->image)
                                <img src="{{ url('/uploads/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="text-xs text-slate-400 block mb-2">
                                🗓️ {{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->format('d M Y') }}
                            </span>
                            <h3 class="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition line-clamp-2">
                                {{ $post->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 mb-4 flex-grow">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <span class="text-xs font-semibold text-emerald-600 group-hover:underline">
                                Baca Selengkapnya →
                            </span>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400 text-sm">
                        Belum ada berita dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PETA LOKASI & ALAMAT MASJID -->
    <section class="py-16 bg-white border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10 items-center">

                <!-- INFORMASI ALAMAT -->
                <div>
                    <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">
                        Lokasi Masjid
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">
                        Kunjungi Masjid Nurul Ikhlas
                    </h2>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        Masjid kami terbuka 24 jam untuk musafir dan jamaah yang ingin beribadah. Terletak di kawasan yang
                        strategis, aman, dan memiliki area parkir luas.
                    </p>

                    <div class="space-y-4 text-sm text-slate-700">
                        <div class="flex items-start gap-3">
                            <span class="text-lg mt-0.5">📍</span>
                            <div>
                                <strong class="block text-slate-900 font-semibold">Alamat Lengkap:</strong>
                                <span class="text-xs text-slate-500">Jl. Suka Rela, Kelurahan Tuah Madani, Kec. Tampan,
                                    Kota Pekanbaru, Riau 28293</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-lg mt-0.5">📞</span>
                            <div>
                                <strong class="block text-slate-900 font-semibold">Kontak Sekretariat DKM:</strong>
                                <span class="text-xs text-slate-500">+62 812-3456-7890 (Humas / Call Center)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EMBED GOOGLE MAPS -->
                <div
                    class="rounded-3xl overflow-hidden shadow-lg border border-slate-200/80 h-72 md:h-80 w-full relative bg-slate-100">
                    <!-- Gantilah src iframe ini dengan link embed Google Maps asli Masjid kamu nantinya -->
                    <iframe class="w-full h-full border-0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d45138.25020667178!2d101.35595911827951!3d0.4498417106714505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a981fcf12917%3A0x8d0b51abeb4ebd6!2sMASJID%20NURUL%20IKHLAS!5e0!3m2!1sid!2sid!4v1785158617070!5m2!1sid!2sid"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </section>
@endsection
