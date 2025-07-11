<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermohonanResource\Pages;
use App\Filament\Resources\PermohonanResource\RelationManagers;
use App\Models\Permohonan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, Grid, Select, TextInput, DatePicker, Textarea, FileUpload};
use Illuminate\Support\Facades\Auth;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static ?string $label = 'Permohonan';
    protected static ?string $navigationGroup = 'Keuangan, Peminjaman & Fasilitas';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down'; // 📥 Permintaan/Masuk
    protected static ?string $activeNavigationIcon = 'heroicon-s-inbox-arrow-down';
    protected static ?int $navigationSort = 7;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 5 ? 'warning' : 'info';
    }

    protected static ?string $navigationBadgeTooltip = 'Total Permohonan';
    protected static ?string $slug = 'permohonan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulir Permohonan Surat')
                    ->icon('heroicon-o-document-text')
                    ->description('Lengkapi data permohonan surat untuk keperluan warga.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->label('Nama Warga')
                                ->relationship('users', 'name') // ganti sesuai field nama di tabel users
                                ->searchable()
                                ->preload()
                                ->required()
                                ->default(Auth::user()->id)
                                ->helperText('Pilih warga yang mengajukan surat.'),

                            DatePicker::make('tanggal')
                                ->label('Tanggal Permohonan')
                                ->required(),
                        ]),

                        Select::make('jenis')
                            ->label('Jenis Surat')
                            ->options([
                                'SKTM' => 'Surat Keterangan Tidak Mampu',
                                'Domisili' => 'Surat Domisili',
                                'Usaha' => 'Surat Keterangan Usaha',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->reactive()
                            ->helperText('Pilih jenis surat yang dibutuhkan.'),

                        TextInput::make('jenis_lainnya')
                            ->label('Jenis Lainnya')
                            ->placeholder('Contoh: Surat Izin Keramaian')
                            ->maxLength(20)
                            ->dehydrated()
                            ->visible(fn($get) => $get('jenis') === 'Lainnya')
                            ->requiredIf('jenis', 'Lainnya')
                            ->helperText('Diisi jika jenis surat tidak tersedia dalam pilihan.'),

                        Textarea::make('keperluan')
                            ->label('Keperluan')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull()
                            ->placeholder('Contoh: Untuk keperluan administrasi sekolah.')
                            ->helperText('Jelaskan secara ringkas keperluan surat.'),

                        Select::make('status')
                            ->label('Status Permohonan')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diproses' => 'Diproses',
                                'Selesai' => 'Selesai',
                            ])
                            ->default('Menunggu')
                            ->required(),

                        FileUpload::make('file_pendukung')
                            ->label('File Pendukung')
                            ->directory('file-pendukung')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(2048)
                            ->required()
                            ->helperText('Unggah dokumen pendukung (gambar/pdf, max 2MB).'),

                        FileUpload::make('file_surat')
                            ->label('File Surat Jadi')
                            ->directory('file-surat')
                            ->helperText('Upload file surat setelah disetujui. (PDF)')
                            ->visible(fn($get) => $get('status') === 'Selesai'),
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
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_pendukung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_surat')
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
            'index' => Pages\ListPermohonans::route('/'),
            'create' => Pages\CreatePermohonan::route('/create'),
            'view' => Pages\ViewPermohonan::route('/{record}'),
            'edit' => Pages\EditPermohonan::route('/{record}/edit'),
        ];
    }
}
