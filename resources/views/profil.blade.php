@extends('layouts.app')

@section('title', 'Profil & Pengurus - Masjid Nurul Ikhlas Pekanbaru')

@section('content')
    <!-- HERO PROFIL -->
    <div class="bg-emerald-800 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <span class="text-emerald-300 text-xs font-bold uppercase tracking-widest block mb-2">Tentang Kami</span>
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Profil & Kepengurusan DKM</h1>
            <p class="text-emerald-100 text-sm max-w-2xl mx-auto leading-relaxed">
                Mengenal lebih dekat Masjid Nurul Ikhlas Pekanbaru, visi misi kemakmuran masjid, serta jajaran pengurus DKM.
            </p>
        </div>
    </div>

    <!-- VISI MISI & SEJARAH SINGKAT -->
    <div class="py-16 bg-white border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">Visi & Misi</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Mewujudkan Pusat Peradaban & Pelayanan Umat
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Masjid Nurul Ikhlas berkomitmen untuk tidak hanya menjadi tempat ibadah ritual, tetapi juga pusat
                    kegiatan sosial, pendidikan, dan pemberdayaan ekonomi jamaah di Pekanbaru.
                </p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Menyelenggarakan peribadatan yang tertib dan
                        nyaman.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Mengembangkan pendidikan Al-Qur'an dan kajian
                        keislaman rutin.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Mengelola dana infaq & anak yatim secara
                        transparan dan akuntabel.
                    </li>
                </ul>
            </div>
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                <h3 class="font-bold text-slate-900 text-lg mb-3">Fasilitas Masjid</h3>
                <div class="grid grid-cols-2 gap-4 text-xs text-slate-600">
                    <div class="bg-white p-3 rounded-xl border border-slate-100">❄️ Ruangan yang sejuk</div>
                    <div class="bg-white p-3 rounded-xl border border-slate-100">🅿️ Area Parkir Luas</div>
                    <div class="bg-white p-3 rounded-xl border border-slate-100">💧 Tempat Wudhu yang bersih</div>
                    {{-- <div class="bg-white p-3 rounded-xl border border-slate-100">📚 Perpustakaan Islam</div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR PENGURUS DKM (BAGAN STRUCTURAL) -->
    <div class="py-16 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-5xl mx-auto px-4">

            <!-- HEADER BAGAN -->
            <div class="text-center max-w-xl mx-auto mb-14">
                <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest block mb-1">Struktur
                    Kepengurusan</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">Masjid Nurul Ikhlas Pekanbaru</h2>
                <p class="text-xs text-slate-500">Khidmat Pelayanan & Pengelolaan Kemakmuran Masjid</p>
            </div>

            @if ($boardMembers->count() > 0)
                <div class="space-y-10">

                    <!-- LEVEL 1: POSISI ATAS (Pelindung / Penasehat / Ketua / Wakil) -->
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach ($boardMembers->whereIn('order', [1, 2, 3, 4]) as $member)
                            <div
                                class="w-full sm:w-80 bg-white rounded-2xl p-6 border border-emerald-200/80 shadow-sm text-center relative mt-3 hover:shadow-md transition">

                                <!-- BADGE JABATAN -->
                                <span
                                    class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-700 text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    {{ $member->position }}
                                </span>

                                <!-- FOTO JIKA ADA -->
                                @if ($member->photo)
                                    <div
                                        class="w-16 h-16 mx-auto mt-2 mb-3 rounded-full overflow-hidden border-2 border-emerald-500">
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->position }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="pt-2"></div>
                                @endif

                                <!-- DAFTAR NAMA BERURUT KE BAWAH -->
                                <div class="space-y-1.5">
                                    @foreach ($member->name_list as $nama)
                                        <p class="font-bold text-slate-800 text-sm md:text-base leading-snug">
                                            {{ $nama }}
                                        </p>
                                    @endforeach
                                </div>

                                @if ($member->phone)
                                    <span
                                        class="text-[11px] text-emerald-600 font-medium block mt-3 pt-2 border-t border-slate-100">
                                        📞 {{ $member->phone }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- SEPARATING LINE / GARIS BAGAN -->
                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span
                            class="flex-shrink mx-4 text-xs font-semibold text-slate-400 bg-slate-200/60 px-3 py-1 rounded-full">
                            Seksi & Bidang Pelaksana
                        </span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <!-- LEVEL 2: SEKSI - SEKSI & BIDANG (SAMA TINGGI & AUTOFIT) -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                        @foreach ($boardMembers->whereNotIn('order', [1, 2, 3, 4]) as $member)
                            <!-- Tambahkan h-full, flex, flex-col, justify-between -->
                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm text-center relative mt-3 hover:shadow-md transition h-full flex flex-col justify-between">

                                <div>
                                    <!-- BADGE JABATAN SEKSI -->
                                    <span
                                        class="absolute -top-3 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs font-bold px-4 py-1 rounded-full border border-slate-700 whitespace-nowrap shadow-sm">
                                        {{ $member->position }}
                                    </span>

                                    <!-- DAFTAR NAMA SEKSI BERURUT KE BAWAH -->
                                    <div class="mt-3 space-y-2">
                                        @foreach ($member->name_list as $nama)
                                            <p class="text-sm md:text-base font-medium text-slate-800 block leading-snug">
                                                {{ $nama }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- KONTAK WA / HP (Otomatis terdorong ke paling bawah card) -->
                                @if ($member->phone)
                                    <span class="text-xs text-slate-400 block mt-4 pt-3 border-t border-slate-100">
                                        📞 {{ $member->phone }}
                                    </span>
                                @endif

                            </div>
                        @endforeach
                    </div>

                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 text-slate-400 text-sm">
                    Belum ada data pengurus diinputkan.
                </div>
            @endif

        </div>
    </div>
@endsection
