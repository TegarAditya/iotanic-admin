<?php

namespace App\Filament\Resources\LandResource\RelationManagers;

use App\Models\Measurement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use stdClass;

use function Pest\Laravel\json;

class MeasurementsRelationManager extends RelationManager
{
    protected static string $relationship = 'measurements';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('plant_variety_id')
                    ->label('Varietas Tanaman')
                    ->relationship('plantVariety', 'name')
                    ->required(),
                Forms\Components\Select::make('period_id')
                    ->label('Periode')
                    ->relationship('period', 'name')
                    ->required(),
                Forms\Components\Select::make('land_id')
                    ->label('Lahan')
                    ->relationship('land', 'name')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('public_id')
            ->columns([
                Tables\Columns\TextColumn::make('public_id')
                    ->label('Public ID')
                    ->fontFamily(FontFamily::Mono),
                Tables\Columns\TextColumn::make('plantVariety.plant.name')
                    ->label('Tanaman'),
                Tables\Columns\TextColumn::make('plantVariety.name')
                    ->label('Varietas'),
                Tables\Columns\TextColumn::make('period.name')
                    ->label('Periode'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->icon('heroicon-o-eye'),
                // ->url(fn (Measurement $record): string => LandResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\Action::make('qr-code')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->action(function (Measurement $record) {
                        return response()->streamDownload(
                            function () use ($record) {
                                $qrPayload = new stdClass();
                                $qrPayload->land = $record->land->name;
                                $qrPayload->variety = $record->plantVariety->name;
                                $qrPayload->measurement_id = $record->id;

                                $payload = json_encode($qrPayload);

                                echo QrCode::size(200)
                                    ->generate($payload);
                            },
                            $record->public_id . '.svg'
                        );
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
