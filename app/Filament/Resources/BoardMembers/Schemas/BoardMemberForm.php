<?php

namespace App\Filament\Resources\BoardMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BoardMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('position')
                    ->label('Jabatan / Seksi / Bidang')
                    ->placeholder('Contoh: Pelindung / Ketua / Imam / Humas')
                    ->required(),

                Textarea::make('name')
                    ->label('Nama Pengurus')
                    ->placeholder("Contoh:\nLurah Tuahmadani\nKetua RW 01\nKetua RT 01")
                    ->helperText('Tekan ENTER untuk memisahkan nama-nama pengurus agar berurut ke bawah')
                    ->rows(4)
                    ->required(),

                TextInput::make('phone')
                    ->label('Nomor WhatsApp / HP (Opsional)')
                    ->placeholder('Contoh: 081234567890')
                    ->tel(),

                TextInput::make('order')
                    ->label('Urutan Posisi Bagan (Angka)')
                    ->helperText('1=Pelindung, 2=Penasehat, 3=Ketua, 4=Wakil, 5=Sekretaris/Bendahara, 6=Seksi-Seksi/Imam')
                    ->numeric()
                    ->default(1)
                    ->required(),

                FileUpload::make('photo')
                    ->label('Foto Pengurus / Logo (Opsional)')
                    ->image()
                    ->directory('board-members')
                    ->columnSpanFull()
                    ->helperText('Upload foto jika perorangan (Opsional)'),
            ]);
    }
}