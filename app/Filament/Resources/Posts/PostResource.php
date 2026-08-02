<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Schemas\PostForm;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    // 1. Ganti Ikon ke Koran / Berita (Newspaper)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    // 2. Ganti Label Menu Sidebar dan Judul Halaman ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Berita & Pengumuman';
    protected static ?string $modelLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita & Pengumuman';

    // 3. Atur Urutan Menu di Sidebar (Angka 4 = Di bawah Jadwal Kajian)
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}