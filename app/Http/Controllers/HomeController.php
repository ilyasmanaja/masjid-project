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

        $prayerSchedule = null;
        try {
            $response = Http::timeout(3)->get('https://api.myquran.com/v2/sholat/jadwal/0401/' . date('Y/m/d'));
            if ($response->successful()) {
                $prayerSchedule = $response->json()['data']['jadwal'] ?? null;
            }
        } catch (\Exception $e) {
            $prayerSchedule = null;
        }

        return view('home', compact('boardMembers', 'posts', 'events', 'kasOperasional', 'kasPembangunan', 'kasYatim', 'totalSaldo', 'prayerSchedule'));
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
}