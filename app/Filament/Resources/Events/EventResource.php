<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    // 1. Ganti Ikon ke Kalender (Calendar Days)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    // 2. Ganti Label Menu Sidebar dan Judul Halaman ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Jadwal Kajian & Acara';
    protected static ?string $modelLabel = 'Jadwal Kajian';
    protected static ?string $pluralModelLabel = 'Jadwal Kajian & Acara';

    // 3. Atur Urutan Menu di Sidebar (Angka 3 = Di bawah Kas Keuangan)
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}