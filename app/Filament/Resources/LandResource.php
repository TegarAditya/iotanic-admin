<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandResource\Pages;
use App\Filament\Resources\LandResource\RelationManagers;
use App\Filament\Resources\LandResource\RelationManagers\MeasurementsRelationManager;
use App\Models\Land;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use URL;

class LandResource extends Resource
{
    protected static ?string $model = Land::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Data Pengguna';

    protected static ?string $modelLabel = 'Lahan';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Lahan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lahan')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('user_id')
                            ->label('Pemilik Lahan')
                            ->relationship('user', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('area')
                            ->label('Luas Lahan')
                            ->suffix(fn () => new HtmlString('m<sup>2</sup>'))
                            ->default(null),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Lahan')
                            ->columnSpanFull()
                            ->default("-")
                    ]),
                Forms\Components\Section::make('Lokasi')
                    ->columns(2)
                    ->schema([
                        Geocomplete::make('location')
                            ->label('Alamat Lengkap')
                            ->isLocation()
                            ->geocodeOnLoad()
                            ->updateLatLng()
                            ->columnSpanFull()
                            ->default(null),
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->default(null)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => floatVal($get('longitude')),
                                ]);
                            })
                            ->lazy(),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->default(null)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => floatVal($get('longitude')),
                                ]);
                            })
                            ->lazy(),
                        Map::make('location')
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->autocomplete(
                                fieldName: 'address',
                                placeField: 'name',
                                countries: ['ID'],
                            )
                            ->mapControls([
                                'mapTypeControl'    => true,
                                'scaleControl'      => true,
                                'streetViewControl' => true,
                                'rotateControl'     => true,
                                'fullscreenControl' => true,
                                'searchBoxControl'  => false,
                                'zoomControl'       => false,
                            ])
                            ->height(fn () => '400px')
                            ->defaultZoom(17)
                            ->autocomplete('full_address')
                            ->autocompleteReverse(true)
                            ->reverseGeocode([
                                'street' => '%n %S',
                                'city' => '%L',
                                'state' => '%A1',
                                'zip' => '%z',
                            ])
                            ->debug()
                            ->defaultLocation([39.526610, -107.727261])
                            ->draggable()
                            ->clickable(false)
                            ->geolocate()
                            ->geolocateLabel('Get Location')
                            ->geolocateOnLoad(true, false)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('public_id')
                    ->label('ID')
                    ->fontFamily(FontFamily::Mono)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemilik')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area')
                    ->label('Luas')
                    ->suffix(fn () => new HtmlString('m<sup>2</sup>'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
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

    public static function getRelations(): array
    {
        return [
            MeasurementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLands::route('/'),
            'create' => Pages\CreateLand::route('/create'),
            'edit' => Pages\EditLand::route('/{record}/edit'),
        ];
    }
}
