<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, Grid, Select, DatePicker, Repeater, TextInput};
use Illuminate\Support\Facades\Auth;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $label = 'Peminjaman Barang';
    protected static ?string $navigationGroup = 'Keuangan, Peminjaman & Fasilitas';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path'; // 🔄 Perputaran barang/peminjaman
    protected static ?string $activeNavigationIcon = 'heroicon-s-arrow-path';
    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 1 ? 'danger' : 'success';
    }

    protected static ?string $navigationBadgeTooltip = 'Total Peminjaman';
    protected static ?string $slug = 'peminjaman-barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Peminjaman')
                    ->icon('heroicon-o-hand-raised')
                    ->description('Lengkapi data peminjam dan tanggal pinjam.')
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make('tanggal_pinjam')
                                ->label('Tanggal Pinjam')
                                ->required(),

                            DatePicker::make('tanggal_kembali')
                                ->label('Tanggal Kembali')
                                ->required(),

                            Select::make('user_id')
                                ->label('Nama Peminjam')
                                ->relationship('users', 'name') // sesuaikan dengan kolom di tabel users
                                ->searchable()
                                ->preload()
                                ->required()
                                ->default(Auth::user()->id),

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Menunggu' => 'Menunggu',
                                    'Diterima' => 'Diterima',
                                    'Ditolak' => 'Ditolak',
                                ]) // sesuaikan dengan kolom di tabel users
                                ->searchable()
                                ->preload()
                                ->required()
                                ->default('Menunggu')
                        ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Detail Barang Dipinjam')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Tambahkan detail barang yang dipinjam.')
                    ->schema([
                        Repeater::make('detailPeminjamen')
                            ->label('Barang Dipinjam')
                            ->relationship() // asumsi peminjaman hasMany detailPeminjamans
                            ->schema([
                                Grid::make(2)->schema([
                                    Select::make('barang_id')
                                        ->label('Nama Barang')
                                        ->relationship('barangs', 'nama') // sesuaikan jika nama field berbeda
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    TextInput::make('jumlah_dipinjam')
                                        ->label('Jumlah Dipinjam')
                                        ->numeric()
                                        ->required()
                                        ->minValue(1),
                                ]),

                                TextInput::make('jumlah_kembali')
                                    ->label('Jumlah Dikembalikan')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Kosongkan jika barang belum dikembalikan.'),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Barang')
                            ->columns(1)
                            ->collapsible()
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'view' => Pages\ViewPeminjaman::route('/{record}'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
