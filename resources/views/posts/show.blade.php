@extends('layouts.app')

@section('title', $post->title . ' - Masjid Nurul Ikhlas')

@section('content')
<div class="py-12 bg-white border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-xs font-medium text-slate-400 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('posts.index') }}" class="hover:text-emerald-600">Berita</a>
            <span>/</span>
            <span class="text-slate-600 truncate max-w-xs">{{ $post->title }}</span>
        </nav>

        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
            {{ $post->title }}
        </h1>

        <div class="flex items-center gap-4 text-xs text-slate-500 mb-8 pb-6 border-b border-slate-100">
            <span>🗓️ {{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}</span>
            <span>•</span>
            <span>✍️ DKM Nurul Ikhlas</span>
        </div>

        @if($post->image)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-sm max-h-[450px]">
                <img src="{{ url('/uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- ISI BERITA (Rich Text / HTML) -->
        <div class="prose prose-emerald max-w-none text-slate-700 leading-relaxed text-base space-y-4">
            {!! $post->content !!}
        </div>

        <div class="mt-12 pt-6 border-t border-slate-100">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                ← Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</div>
@endsection