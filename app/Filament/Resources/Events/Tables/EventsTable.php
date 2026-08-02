<?php

namespace App\Filament\Resources\Events\Tables;

use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Kegiatan / Kajian')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'emerald' => 'rutin',
                        'amber' => 'insidental',
                    ])
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'rutin' => 'Rutin',
                        'insidental' => 'Insidental',
                        default => '-',
                    }),

                TextColumn::make('waktu_pelaksanaan')
                    ->label('Waktu Pelaksanaan')
                    ->state(function (Event $record): string {
                        if ($record->type === 'rutin') {
                            return $record->routine_day ?? '-';
                        }
                        return $record->event_date ? $record->event_date->format('d M Y, H:i') . ' WIB' : '-';
                    }),

                TextColumn::make('speaker')
                    ->label('Penceramah / PJ')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Filter Tipe')
                    ->options([
                        'rutin' => 'Rutin',
                        'insidental' => 'Insidental',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}