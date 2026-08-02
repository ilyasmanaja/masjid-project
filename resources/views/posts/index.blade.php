@extends('layouts.app')

@section('title', 'Berita & Pengumuman - Masjid Nurul Ikhlas')

@section('content')
<div class="py-12 bg-slate-50 border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Berita & Pengumuman</h1>
        <p class="text-slate-500 text-sm mb-8">Informasi dan laporan kegiatan terkini dari Masjid Nurul Ikhlas Pekanbaru.</p>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition group flex flex-col">
                    <div class="h-48 bg-slate-100 overflow-hidden">
                        @if($post->image)
                            <img src="{{ url('/uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-sm">No Image</div>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-xs text-slate-400 block mb-2">{{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->format('d M Y') }}</span>
                        <h2 class="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition line-clamp-2">{{ $post->title }}</h2>
                        <p class="text-xs text-slate-500 line-clamp-3 mb-4 flex-grow">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                        <span class="text-xs font-semibold text-emerald-600 group-hover:underline">Baca Selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">Belum ada berita dipublikasikan.</div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection