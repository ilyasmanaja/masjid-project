<?php

namespace App\Filament\Resources\BoardMembers;

use App\Filament\Resources\BoardMembers\Pages\CreateBoardMember;
use App\Filament\Resources\BoardMembers\Pages\EditBoardMember;
use App\Filament\Resources\BoardMembers\Pages\ListBoardMembers;
use App\Filament\Resources\BoardMembers\Schemas\BoardMemberForm;
use App\Filament\Resources\BoardMembers\Tables\BoardMembersTable;
use App\Models\BoardMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BoardMemberResource extends Resource
{
    protected static ?string $model = BoardMember::class;

    // 1. Ganti Ikon ke Ikon Kelompok Orang (User Group)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    // 2. Ganti Label Menu Sidebar dan Judul Halaman ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Data Pengurus Masjid';
    protected static ?string $modelLabel = 'Pengurus';
    protected static ?string $pluralModelLabel = 'Data Pengurus';

    // 3. Atur Urutan Menu di Sidebar (Angka 1 = Paling Atas)
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BoardMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BoardMembersTable::configure($table);
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
            'index' => ListBoardMembers::route('/'),
            'create' => CreateBoardMember::route('/create'),
            'edit' => EditBoardMember::route('/{record}/edit'),
        ];
    }
}