<?php

namespace App\Filament\Resources\PlantVarietyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThresholdsRelationManager extends RelationManager
{
    protected static string $relationship = 'thresholds';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('plant_variety_id')
                    ->relationship('plantVariety', 'name')
                    ->label('Varietas Tanaman')
                    ->required(),
                Forms\Components\Select::make('period_id')
                    ->label('Periode')
                    ->relationship('period', 'name')
                    ->required(),
                Forms\Components\Section::make('Nilai Treshold')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('natrium_min')
                            ->label('Natrium Min')
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('natrium_max')
                            ->label('Natrium Max')
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('kalium_min')
                            ->label('Kalium Min')
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('kalium_max')
                            ->label('Kalium Max')
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('ph_min')
                            ->label('pH Min')
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('ph_max')
                            ->label('pH Max')
                            ->required()
                            ->default(0),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('plantVariety.name')
                    ->label('Varietas Tanaman')
                    ->searchable(),
                Tables\Columns\TextColumn::make('period.name')
                    ->label('Periode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('natrium_min')
                    ->label('Natrium Min'),
                Tables\Columns\TextColumn::make('natrium_max')
                    ->label('Natrium Max'),
                Tables\Columns\TextColumn::make('kalium_min')
                    ->label('Kalium Min'),
                Tables\Columns\TextColumn::make('kalium_max')
                    ->label('Kalium Max'),
                Tables\Columns\TextColumn::make('ph_min')
                    ->label('pH Min'),
                Tables\Columns\TextColumn::make('ph_max')
                    ->label('pH Max'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
