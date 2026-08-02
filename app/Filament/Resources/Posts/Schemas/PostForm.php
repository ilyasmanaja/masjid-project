<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Berita / Pengumuman')
                    ->placeholder('Contoh: Pelaksanaan Laporan Qurban Tahun ini')
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('URL Slug (Otomatis)')
                    ->readOnly()
                    ->required(),

                Textarea::make('excerpt')
                    ->label('Ringkasan Singkat Berita')
                    ->placeholder('Isi 1-2 kalimat ringkasan yang akan muncul di halaman depan...')
                    ->rows(2)
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Isi Berita / Laporan Lengkap')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Foto Utama Berita')
                    ->image()
                    ->directory('posts')
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Tampilkan Berita Ini di Web Utama?')
                    ->default(true),

                DateTimePicker::make('published_at')
                    ->label('Tanggal Terbit')
                    ->default(now()),
            ]);
    }
}