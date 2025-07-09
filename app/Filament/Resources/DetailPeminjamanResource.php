<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailPeminjamanResource\Pages;
use App\Filament\Resources\DetailPeminjamanResource\RelationManagers;
use App\Models\DetailPeminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailPeminjamanResource extends Resource
{
    protected static ?string $model = DetailPeminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('peminjaman_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('barang_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_dipinjam')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_kembali')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peminjaman_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barang_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_dipinjam')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_kembali')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDetailPeminjamen::route('/'),
        ];
    }
}
