<?php

namespace App\Filament\Monset\Resources\Monset;

use App\Filament\Monset\Resources\Monset\ClipResource\Pages;
use App\Filament\Monset\Resources\Monset\ClipResource\RelationManagers;
use App\Models\Core\Surah;
use App\Models\Core\Verse;
use App\Models\Monset\Clip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\TranslatablePro\Filament\Forms\Components\MultiLang;

class ClipResource extends Resource
{
    protected static ?string $model = Clip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MultiLang::make('title')
                    ->required(['ar']),
                MultiLang::make('description')
                    ->required(['ar']),

                Forms\Components\Repeater::make('verses')
                    ->columnSpanFull()
                    ->relationship()
                    ->orderColumn('order')
                    ->reorderable()
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('surah_id')
                                    ->live()
                                    ->dehydrated(false)
                                    ->searchable()
                                    ->options(Surah::all()->pluck('id', 'id'))
                                    ->optionsLimit(10),
                                Forms\Components\Select::make('start_verse_id')
                                    ->searchable()
                                    ->options(fn(Forms\Get $get) => $get('surah_id') ? Verse::where('surah_id', $get('surah_id'))->pluck('id', 'id') : [])
                                    ->optionsLimit(10),
                                Forms\Components\Select::make('end_verse_id')
                                    ->searchable()
                                    ->options(fn(Forms\Get $get) => $get('surah_id') ? Verse::where('surah_id', $get('surah_id'))->pluck('id', 'id') : [])
                                    ->optionsLimit(10),
                            ])


                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('description'),

            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListClips::route('/'),
            'create' => Pages\CreateClip::route('/create'),
            'edit' => Pages\EditClip::route('/{record}/edit'),
        ];
    }
}
