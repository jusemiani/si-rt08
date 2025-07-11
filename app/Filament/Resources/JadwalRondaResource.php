<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalRondaResource\Pages;
use App\Filament\Resources\JadwalRondaResource\RelationManagers;
use App\Models\JadwalRonda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Grid, Section, TextInput, Select, FileUpload, datePicker};

class JadwalRondaResource extends Resource
{
    protected static ?string $model = JadwalRonda::class;
    protected static ?string $label = 'Jadwal Ronda';
    protected static ?string $navigationGroup = 'Kegiatan & Keamanan';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days'; // 📅 Jadwal
    protected static ?string $activeNavigationIcon = 'heroicon-s-calendar-days';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 3 ? 'danger' : 'success';
    }

    protected static ?string $navigationBadgeTooltip = 'Total Jadwal Ronda';
    protected static ?string $slug = 'jadwal-ronda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Penjadwalan Ronda Warga')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Isi data jadwal ronda untuk warga RT.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->label('Nama Warga')
                                ->relationship('users', 'name') // Asumsikan kolom 'nama' ada di tabel users
                                ->searchable()
                                ->preload()
                                ->required()
                                ->helperText('Pilih warga yang dijadwalkan untuk ronda.'),

                            DatePicker::make('tanggal')
                                ->label('Tanggal Ronda')
                                ->native(false)
                                ->required()
                                ->helperText('Pilih tanggal pelaksanaan ronda.'),
                        ]),

                        Select::make('shift')
                            ->label('Shift Ronda')
                            ->options([
                                1 => 'Malam 1 (22:00 - 00:00)',
                                2 => 'Malam 2 (00:00 - 04:00)',
                            ])
                            ->required()
                            ->helperText('Pilih waktu ronda warga.')
                            ->native(false),
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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shift')
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
            'index' => Pages\ManageJadwalRondas::route('/'),
        ];
    }
}
