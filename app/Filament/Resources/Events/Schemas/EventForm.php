<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Kajian / Nama Acara')
                    ->placeholder('Contoh: Kajian Kitab Ryadush Shalihin / Gotong Royong Akbar')
                    ->required()
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Tipe Kegiatan')
                    ->options([
                        'rutin' => 'Rutin (Berulang Pekanan/Harian)',
                        'insidental' => 'Insidental (Sekali Jalan / Tanggal Spesifik)',
                    ])
                    ->default('rutin')
                    ->required()
                    ->live() // Mengupdate schema secara interaktif
                    ->columnSpanFull(),

                // Muncul jika tipe 'rutin'
                TextInput::make('routine_day')
                    ->label('Hari & Waktu Rutin')
                    ->placeholder('Contoh: Setiap Minggu Ba\'da Subuh / Setiap Jumat Malam')
                    ->required(fn (Get $get): bool => $get('type') === 'rutin')
                    ->visible(fn (Get $get): bool => $get('type') === 'rutin'),

                // Muncul jika tipe 'insidental'
                DateTimePicker::make('event_date')
                    ->label('Tanggal & Waktu Pelaksanaan')
                    ->required(fn (Get $get): bool => $get('type') === 'insidental')
                    ->visible(fn (Get $get): bool => $get('type') === 'insidental'),

                TextInput::make('speaker')
                    ->label('Nama Ustaz / Penceramah / PJ')
                    ->placeholder('Contoh: Ust. Dr. H. Das\'ad Latif (Opsional)')
                    ->nullable(),

                TextInput::make('location')
                    ->label('Lokasi Kegiatan')
                    ->default('Ruang Utama Masjid Nurul Ikhlas')
                    ->required(),

                FileUpload::make('poster')
                    ->label('Poster / Brosur Kajian')
                    ->image()
                    ->directory('events')
                    ->helperText('Upload gambar poster kajian jika ada (Opsional)')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi Singkat (Opsional)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}