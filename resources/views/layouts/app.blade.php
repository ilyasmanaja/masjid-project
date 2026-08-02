<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masjid Nurul Ikhlas - Pekanbaru')</title>


    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/favicon.png') }}" alt="Logo Masjid Nurul Ikhlas"
                    class="w-10 h-10 object-contain rounded-xl shadow-sm">
                <div>
                    <h1 class="font-bold text-slate-900 leading-tight">Nurul Ikhlas</h1>
                    <p class="text-xs text-slate-500">Pekanbaru, Riau</p>
                </div>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}"
                    class="hover:text-emerald-600 transition {{ request()->routeIs('home') ? 'text-emerald-600 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('keuangan') }}"
                    class="hover:text-emerald-600 transition {{ request()->routeIs('keuangan') ? 'text-emerald-600 font-semibold' : '' }}">Keuangan
                    Kas</a>
                <a href="{{ route('profil') }}"
                    class="hover:text-emerald-600 transition {{ request()->routeIs('profil') ? 'text-emerald-600 font-semibold' : '' }}">Profil
                    & DKM</a>
                <a href="{{ route('kajian') }}"
                    class="hover:text-emerald-600 transition {{ request()->routeIs('kajian') ? 'text-emerald-600 font-semibold' : '' }}">Jadwal
                    Kajian</a>
                <a href="{{ route('posts.index') }}"
                    class="hover:text-emerald-600 transition {{ request()->routeIs('posts.*') ? 'text-emerald-600 font-semibold' : '' }}">Berita</a>
            </nav>
            <a href="#donasi"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                Infaq / Donasi
            </a>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER & DONASI -->
    <footer id="donasi" class="bg-slate-900 text-white py-16 border-t border-slate-800 mt-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10 items-center pb-12 border-b border-slate-800">

                <!-- KOLOM 1: DESKRIPSI & TRANSPARANSI -->
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold mb-3 border border-emerald-500/30">
                        Amal Jariah
                    </span>
                    <h3 class="text-2xl md:text-3xl font-bold mb-3">Layanan Infaq & Donasi</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Salurkan infaq terbaik Anda untuk operasional, pemeliharaan, dan kemakmuran Masjid Nurul Ikhlas
                        Pekanbaru.
                    </p>
                    <div
                        class="flex items-center gap-2 text-xs text-slate-300 bg-slate-800/60 p-3 rounded-xl border border-slate-700/50 w-fit">
                        <span>💡 Laporan penggunaan dana dapat dilihat transparan di halaman</span>
                        <a href="{{ route('keuangan') }}"
                            class="text-emerald-400 font-semibold hover:underline">Keuangan Kas →</a>
                    </div>
                </div>

                <!-- KOLOM 2: KARTU REKENING & KONTAK KONFIRMASI -->
                <div class="space-y-4">
                    <!-- Kartu Rekening BSI -->
                    <div
                        class="bg-slate-800/90 p-5 rounded-2xl border border-slate-700/60 flex items-center justify-between shadow-lg">
                        <div>
                            {{-- Rekening --}}
                            <span class="text-xs text-slate-400 block mb-1">No Rekening</span>
                            <div class="flex items-center gap-3">
                                {{-- nomor rekening --}}
                                <span id="rekening-bsi"
                                    class="font-mono text-emerald-400 text-xl font-bold tracking-wide">-</span>
                                <button onclick="copyRekening()"
                                    class="bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 text-xs px-2.5 py-1 rounded-lg border border-emerald-500/30 transition flex items-center gap-1 active:scale-95">
                                    <span id="copy-icon">📋</span>
                                    <span id="copy-text">Salin</span>
                                </button>
                            </div>
                            <span class="text-xs text-slate-300 block mt-1">a.n. DKM Masjid Nurul Ikhlas</span>
                        </div>
                        <div
                            class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-2xl border border-emerald-500/20 hidden sm:flex">
                            🏦
                        </div>
                    </div>

                    <!-- Informasi Konfirmasi WA -->
                    <div
                        class="bg-slate-800/40 p-4 rounded-xl border border-slate-700/40 text-xs text-slate-400 flex items-center justify-between">
                        <span>Konfirmasi Transfer / Informasi DKM:</span>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="text-emerald-400 font-semibold hover:underline flex items-center gap-1">
                            💬 WA DKM
                        </a>
                    </div>
                </div>

            </div>

            <!-- COPYRIGHT -->
            <div
                class="pt-8 text-center text-xs text-slate-500 flex flex-col md:flex-row items-center justify-between gap-4">
                <p>© {{ date('Y') }} Masjid Nurul Ikhlas Pekanbaru. All rights reserved.</p>
                <p>Dikelola oleh Pengurus DKM Nurul Ikhlas.</p>
            </div>
        </div>
    </footer>

    <script>
        function copyRekening() {
            const norek = document.getElementById('rekening-bsi').innerText;

            const showSuccessUI = () => {
                const copyText = document.getElementById('copy-text');
                const copyIcon = document.getElementById('copy-icon');

                copyText.innerText = 'Tersalin!';
                copyIcon.innerText = '✅';

                setTimeout(() => {
                    copyText.innerText = 'Salin';
                    copyIcon.innerText = '📋';
                }, 2000);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(norek).then(showSuccessUI).catch(() => fallbackCopy(norek));
            } else {
                fallbackCopy(norek);
            }

            function fallbackCopy(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    showSuccessUI();
                } catch (err) {
                    alert('Nomor rekening: ' + text);
                }
                document.body.removeChild(textArea);
            }
        }
    </script>
</body>

</html>
