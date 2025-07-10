<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IuranResource\Pages;
use App\Filament\Resources\IuranResource\RelationManagers;
use App\Models\Iuran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Grid, Section, TextInput, Select, FileUpload};
use Illuminate\Support\Facades\Auth;

class IuranResource extends Resource
{
    protected static ?string $model = Iuran::class;
    protected static ?string $label = 'Iuran';
    protected static ?string $navigationGroup = 'Keuangan, Peminjaman & Fasilitas';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes'; // 💵 Uang
    protected static ?string $activeNavigationIcon = 'heroicon-s-banknotes';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 10 ? 'warning' : 'info';
    }

    protected static ?string $navigationBadgeTooltip = 'Total Iuran';
    protected static ?string $slug = 'iuran';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Pembayaran Iuran')
                    ->icon('heroicon-o-currency-dollar')
                    ->description('Silakan isi data pembayaran iuran dengan lengkap.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('tipe_pembayaran')
                                ->label('Tipe Pembayaran')
                                ->options([
                                    'Transfer' => 'Transfer',
                                    'Tunai' => 'Tunai',
                                ])
                                ->required()
                                ->native(false)
                                ->reactive()
                                ->afterStateUpdated(fn($state, callable $set) => $set('bukti', null))
                                ->helperText('Pilih metode pembayaran yang digunakan.'),

                            Select::make('jenis')
                                ->label('Jenis Iuran')
                                ->options([
                                    'Iuran Ronda' => 'Iuran Ronda',
                                    'Iuran Kas' => 'Iuran Kas',
                                    'Iuran Kebersihan' => 'Iuran Kebersihan',
                                ])
                                ->required()
                                ->native(false)
                                ->helperText('Pilih jenis iuran yang dibayarkan.'),
                        ]),

                        FileUpload::make('bukti')
                            ->label('Bukti Pembayaran (Untuk Transfer)')
                            ->directory('bukti-iuran')
                            ->helperText('Unggah bukti pembayaran. Maks 2MB.')
                            ->visible(fn(callable $get) => $get('tipe_pembayaran') === 'Transfer'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->native(false)
                            ->hidden(!Auth::user()->hasRole('Bendahara'))
                            ->dehydrated()
                            ->required()
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipe_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('bukti')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
            'index' => Pages\ManageIurans::route('/'),
        ];
    }
}
