<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengeluaranResource\Pages;
use App\Filament\Resources\PengeluaranResource\RelationManagers;
use App\Models\Pengeluaran;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;
    protected static ?string $label = 'Pengeluaran';
    protected static ?string $navigationGroup = 'Keuangan, Peminjaman & Fasilitas';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $activeNavigationIcon = 'heroicon-s-arrow-down-tray';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationBadgeTooltip = 'Total Data Pengeluaran';
    protected static ?string $slug = 'pengeluaran';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $total = static::getModel()::count();
        return $total < 1 ? 'danger' : ($total < 10 ? 'warning' : 'success');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Pengeluaran')
                    ->description('Catat pengeluaran kas RT dengan data yang valid.')
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make('tanggal')
                                ->label('Tanggal')
                                ->placeholder('Pilih Tanggal')
                                ->native(false)
                                ->required(),

                            Select::make('user_id')
                                ->label('Dicatat Oleh')
                                ->relationship('users', 'name') // pastikan ada relasi user() di model
                                ->default(Auth::user()->id)
                                ->disabled()
                                ->dehydrated()
                                ->searchable()
                                ->required(),

                            TextInput::make('keperluan')
                                ->label('Keperluan')
                                ->placeholder('Contoh: Beli kursi, konsumsi kegiatan')
                                ->required()
                                ->maxLength(100),

                            TextInput::make('jumlah')
                                ->label('Jumlah (Rp)')
                                ->placeholder('Masukkan Jumlah')
                                ->prefix('Rp')
                                ->numeric()
                                ->required(),
                        ]),
                        Select::make('kegiatan_id')
                            ->label('Terkait Kegiatan')
                            ->relationship('kegiatans', 'nama') // relasi ke kegiatan()
                            ->searchable()
                            ->placeholder('Opsional')
                            ->preload()
                            ->nullable(),

                        Textarea::make('keterangan')
                            ->label('Keterangan Tambahan')
                            ->placeholder('Masukkan Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('keperluan')
                    ->label('Keperluan')
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', true)
                    ->sortable(),

                TextColumn::make('kegiatans.nama') // relasi kegiatan()->nama
                    ->label('Kegiatan')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('users.name') // relasi user()->nama
                    ->label('Dicatat Oleh')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ManagePengeluarans::route('/'),
        ];
    }
}
