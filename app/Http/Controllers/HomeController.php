<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\Event;
use App\Models\FinancialReport;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    // 1. Halaman Home
    // 1. Halaman Home
    public function index()
    {
        $boardMembers = BoardMember::orderBy('order', 'asc')->get();
        $posts = Post::where('is_published', true)->latest()->take(3)->get();

        // Ambil maksimal 4 agenda untuk cuplikan di Home (Rutin & Insidental)
        $events = Event::latest()->take(4)->get();

        $kasOperasional = FinancialReport::where('category', 'Operasional')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Operasional')->where('type', 'expense')->sum('amount');
        $kasPembangunan = FinancialReport::where('category', 'Pembangunan')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Pembangunan')->where('type', 'expense')->sum('amount');
        $kasYatim = FinancialReport::where('category', 'Anak Yatim')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Anak Yatim')->where('type', 'expense')->sum('amount');

        $totalSaldo = $kasOperasional + $kasPembangunan + $kasYatim;

        // Ambil Jadwal Sholat (Cukup 1x Request API)
        $prayerData = null;
        try {
            $response = Http::timeout(3)->get('https://api.myquran.com/v2/sholat/jadwal/0401/' . date('Y/m/d'));
            if ($response->successful()) {
                $schedule = $response->json()['data']['jadwal'] ?? null;
                $prayerData = $this->processPrayerTimes($schedule);
            }
        } catch (\Exception $e) {
            $prayerData = null;
        }

        return view('home', compact(
            'boardMembers',
            'posts',
            'events',
            'kasOperasional',
            'kasPembangunan',
            'kasYatim',
            'totalSaldo',
            'prayerData'
        ));
    }

    // 2. Halaman Indeks Berita
    public function posts()
    {
        $posts = Post::where('is_published', true)->latest()->paginate(9);
        return view('posts.index', compact('posts'));
    }

    // 3. Halaman Detail Berita
    public function postDetail($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentPosts = Post::where('is_published', true)->where('id', '!=', $post->id)->latest()->take(5)->get();

        return view('posts.show', compact('post', 'recentPosts'));
    }

    // 4. Halaman Profil & Pengurus
    public function profil()
    {
        $boardMembers = BoardMember::orderBy('order', 'asc')->get();
        return view('profil', compact('boardMembers'));
    }

    // 5. Halaman Jadwal Kajian (Dipisah Rutin & Insidental)
    public function kajian()
    {
        // Ambil kegiatan rutin
        $rutinEvents = Event::where('type', 'rutin')->latest()->get();

        // Ambil kegiatan insidental (urutkan dari tanggal acara terdekat)
        $insidentalEvents = Event::where('type', 'insidental')
            ->orderBy('event_date', 'asc')
            ->get();

        return view('kajian', compact('rutinEvents', 'insidentalEvents'));
    }

    // 6. Halaman Keuangan Kas
    public function keuangan()
    {
        $kasOperasional = FinancialReport::where('category', 'Operasional')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Operasional')->where('type', 'expense')->sum('amount');
        $kasPembangunan = FinancialReport::where('category', 'Pembangunan')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Pembangunan')->where('type', 'expense')->sum('amount');
        $kasYatim = FinancialReport::where('category', 'Anak Yatim')->where('type', 'income')->sum('amount')
            - FinancialReport::where('category', 'Anak Yatim')->where('type', 'expense')->sum('amount');

        $totalSaldo = $kasOperasional + $kasPembangunan + $kasYatim;

        // Ambil 20 transaksi kas terbaru
        $reports = FinancialReport::latest()->paginate(20);

        return view('keuangan', compact('kasOperasional', 'kasPembangunan', 'kasYatim', 'totalSaldo', 'reports'));
    }

    private function processPrayerTimes($schedule)
    {
        if (!$schedule)
            return null;

        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $today = $now->format('Y-m-d');

        // Instance waktu sholat hari ini
        $subuh = \Carbon\Carbon::parse($today . ' ' . $schedule['subuh'], 'Asia/Jakarta');

        // Batas Subuh pakai Syuruq (jika ada dari API) atau +75 menit setelah azan Subuh
        $syuruq = isset($schedule['terbit'])
            ? \Carbon\Carbon::parse($today . ' ' . $schedule['terbit'], 'Asia/Jakarta')
            : $subuh->copy()->addMinutes(60);

        $dzuhur = \Carbon\Carbon::parse($today . ' ' . $schedule['dzuhur'], 'Asia/Jakarta');
        $ashar = \Carbon\Carbon::parse($today . ' ' . $schedule['ashar'], 'Asia/Jakarta');
        $maghrib = \Carbon\Carbon::parse($today . ' ' . $schedule['maghrib'], 'Asia/Jakarta');
        $isya = \Carbon\Carbon::parse($today . ' ' . $schedule['isya'], 'Asia/Jakarta');

        $currentPrayer = null; // Default null (bisa tidak ada yang NOW)
        $nextPrayerKey = 'dzuhur';
        $nextPrayerTime = $dzuhur;

        // DETERMINASI WAKTU AKTIF & NEXT
        if ($now->between($subuh, $syuruq)) {
            // Masih dalam rentang waktu Subuh (Azan s/d Terbit Matahari)
            $currentPrayer = 'subuh';
            $nextPrayerKey = 'dzuhur';
            $nextPrayerTime = $dzuhur;
        } elseif ($now->between($syuruq, $dzuhur)) {
            // Pagi hari setelah Syuruq s/d sebelum Dzuhur (Dhuha / Pagi)
            $currentPrayer = null; // Tidak ada sholat wajib yang NOW
            $nextPrayerKey = 'dzuhur';
            $nextPrayerTime = $dzuhur;
        } elseif ($now->between($dzuhur, $ashar)) {
            $currentPrayer = 'dzuhur';
            $nextPrayerKey = 'ashar';
            $nextPrayerTime = $ashar;
        } elseif ($now->between($ashar, $maghrib)) {
            $currentPrayer = 'ashar';
            $nextPrayerKey = 'maghrib';
            $nextPrayerTime = $maghrib;
        } elseif ($now->between($maghrib, $isya)) {
            $currentPrayer = 'maghrib';
            $nextPrayerKey = 'isya';
            $nextPrayerTime = $isya;
        } elseif ($now->greaterThanOrEqualTo($isya)) {
            $currentPrayer = 'isya';
            $nextPrayerKey = 'subuh';
            $nextPrayerTime = $subuh->copy()->addDay();
        } else {
            // Dini hari sebelum Subuh (00:00 s/d 04:53)
            $currentPrayer = 'isya';
            $nextPrayerKey = 'subuh';
            $nextPrayerTime = $subuh;
        }

        // Hitung selisih waktu countdown
        $diff = $now->diff($nextPrayerTime);
        $countdownText = ($diff->h > 0) ? "in {$diff->h}h {$diff->i}m" : "in {$diff->i}m";

        return [
            'list' => [
                'subuh' => ['name' => 'Subuh', 'icon' => '✨', 'time' => $schedule['subuh']],
                'dzuhur' => ['name' => 'Dzuhur', 'icon' => '☀️', 'time' => $schedule['dzuhur']],
                'ashar' => ['name' => 'Ashar', 'icon' => '⛅', 'time' => $schedule['ashar']],
                'maghrib' => ['name' => 'Maghrib', 'icon' => '🌅', 'time' => $schedule['maghrib']],
                'isya' => ['name' => 'Isya', 'icon' => '🌙', 'time' => $schedule['isya']],
            ],
            'current' => $currentPrayer,
            'next' => $nextPrayerKey,
            'countdown' => $countdownText,
            'imsak' => $schedule['imsak'] ?? '-',
            'maghrib' => $schedule['maghrib'] ?? '-',
        ];
    }
}
