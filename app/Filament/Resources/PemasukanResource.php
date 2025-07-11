<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemasukanResource\Pages;
use App\Filament\Resources\PemasukanResource\RelationManagers;
use App\Models\Pemasukan;
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
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PemasukanResource extends Resource
{
    protected static ?string $model = Pemasukan::class;
    protected static ?string $label = 'Pemasukan';
    protected static ?string $navigationGroup = 'Keuangan, Peminjaman & Fasilitas';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $activeNavigationIcon = 'heroicon-s-arrow-up-tray';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationBadgeTooltip = 'Total Data Pemasukan';
    protected static ?string $slug = 'pemasukan';

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
                Section::make('Form Pemasukan')
                    ->description('Silakan isi data pemasukan kas RT dengan lengkap.')
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make('tanggal')
                                ->label('Tanggal')
                                ->placeholder('Pilih Tanggal')
                                ->native(false)
                                ->required(),

                            Select::make('user_id')
                                ->label('Dicatat Oleh')
                                ->relationship('users', 'name') // pastikan ada relasi di model
                                ->preload()
                                ->searchable()
                                ->default(Auth::user()->id)
                                ->disabled()
                                ->dehydrated()
                                ->required(),

                            Select::make('sumber')
                                ->label('Sumber Dana')
                                ->options([
                                    'Iuran' => 'Iuran',
                                    'Donasi' => 'Donasi',
                                    'Lainnya' => 'Lainnya',
                                ])
                                ->searchable()
                                ->required()
                                ->native(false),

                            TextInput::make('jumlah')
                                ->label('Jumlah (Rp)')
                                ->placeholder('Masukkan Jumlah')
                                ->prefix('Rp')
                                ->numeric()
                                ->required(),

                            Textarea::make('keterangan')
                                ->label('Keterangan Tambahan')
                                ->placeholder('Masukkan Keterangan')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
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

                TextColumn::make('sumber')
                    ->label('Sumber')
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', true)
                    ->summarize([
                        Sum::make(),
                    ])
                    ->sortable(),

                TextColumn::make('users.name') // asumsi relasi user()->nama
                    ->label('Dicatat Oleh')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since() // tampilkan seperti “2 hari yang lalu”
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
            'index' => Pages\ManagePemasukans::route('/'),
        ];
    }
}
