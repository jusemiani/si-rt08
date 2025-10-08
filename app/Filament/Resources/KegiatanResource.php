<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Filament\Resources\KegiatanResource\RelationManagers;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, Grid, TextInput, Textarea, DatePicker, Select, Repeater, FileUpload};

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;
    protected static ?string $label = 'Kegiatan';
    protected static ?string $navigationGroup = 'Kegiatan & Keamanan';
    protected static ?string $navigationIcon = 'heroicon-o-bolt'; // ⚡ Kegiatan/Aktivitas
    protected static ?string $activeNavigationIcon = 'heroicon-s-bolt';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'danger' : 'info';
    }

    protected static ?string $navigationBadgeTooltip = 'Total Kegiatan';
    protected static ?string $slug = 'kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kegiatan')
                    ->icon('heroicon-o-clipboard-document')
                    ->description('Lengkapi data kegiatan yang akan dilaksanakan.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama')
                                ->label('Nama Kegiatan')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Contoh: Kerja Bakti Bersama')
                                ->helperText('Masukkan nama kegiatan dengan jelas.'),

                            DatePicker::make('tanggal')
                                ->label('Tanggal Kegiatan')
                                ->required()
                                ->helperText('Pilih tanggal kegiatan.'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('lokasi')
                                ->label('Lokasi')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Contoh: Balai Warga RT-08')
                                ->helperText('Masukkan lokasi kegiatan.'),

                            Select::make('jenis')
                                ->label('Jenis Kegiatan')
                                ->options([
                                    1 => 'Umum',
                                    2 => 'Ronda',
                                    3 => 'Rapat',
                                    4 => 'Lainnya',
                                ])
                                ->required()
                                ->helperText('Pilih jenis kegiatan.'),
                        ]),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi Kegiatan')
                            ->rows(4)
                            ->required()
                            ->placeholder('Tuliskan detail kegiatan yang akan dilakukan...')
                            ->helperText('Deskripsi ini akan tampil pada informasi kegiatan.'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Galeri Kegiatan')
                    ->icon('heroicon-o-photo')
                    ->description('Unggah dokumentasi kegiatan dalam bentuk gambar.')
                    ->schema([
                        Repeater::make('galeriKegiatans')
                            ->label('Dokumentasi Foto')
                            ->relationship()
                            ->schema([
                                FileUpload::make('gambar')
                                    ->label('Gambar')
                                    ->directory('galeri-kegiatan')
                                    ->image()
                                    ->downloadable()
                                    ->maxSize(2048)
                                    ->required()
                                    ->helperText('Unggah file gambar. Maksimal 2MB.')
                            ])
                            ->columns(1)
                            ->minItems(1)
                            ->addActionLabel('Tambah Gambar')
                            ->grid(3)
                            ->collapsible()
                            ->defaultItems(1),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-clipboard-document')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->wrap()
                    ->icon('heroicon-o-map-pin')
                    ->color('info'),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis Kegiatan')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            '1' => 'Umum',
                            '2' => 'Ronda',
                            '3' => 'Rapat',
                            '4' => 'Lainnya',
                            default => 'Tidak Diketahui',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            '1' => 'primary',
                            '2' => 'success',
                            '3' => 'warning',
                            '4' => 'gray',
                            default => 'danger',
                        };
                    }),

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
            'index' => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'view' => Pages\ViewKegiatan::route('/{record}'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}
