<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Models\Cart;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?string $navigationLabel = 'Carts';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('User')
                ->required(),

            Forms\Components\Select::make('product_id')
                ->relationship('product', 'name')
                ->label('Product')
                ->required(),

            Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->default(1)
                ->label('Quantity'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('product.name')->label('Product')->sortable()->searchable(),
                TextColumn::make('product.category.name')->label('Category'),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('product.price')
                    ->money('idr', true)
                    ->label('Price'),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Added At')
                    ->sortable(),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarts::route('/'),
            'create' => Pages\CreateCart::route('/create'),
            'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
