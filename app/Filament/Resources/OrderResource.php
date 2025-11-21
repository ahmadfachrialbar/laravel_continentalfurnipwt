<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Kelola Pesanan';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $pluralLabel = 'Orders';
    protected static ?string $modelLabel = 'Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Info')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')->disabled(),
                        Forms\Components\TextInput::make('full_name')->required(),
                        Forms\Components\TextInput::make('phone')->required(),
                        Forms\Components\Textarea::make('address')->required(),

                        Forms\Components\TextInput::make('postal_code'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Shipping')
                    ->schema([
                        // PROVINCE SELECT
                        Forms\Components\Select::make('province_id')
                            ->label('Province')
                            ->relationship('province', 'name') // <-- tampilkan nama, simpan ID
                            ->searchable()
                            ->required(),

                        // CITY SELECT
                        Forms\Components\Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->required(),

                        // DISTRICT SELECT
                        Forms\Components\Select::make('district_id')
                            ->label('District')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('courier')->required(),
                        Forms\Components\TextInput::make('weight')->numeric()->required(),
                        Forms\Components\TextInput::make('shipping_cost')->numeric()->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')->numeric()->disabled(),
                        Forms\Components\TextInput::make('total')->numeric()->required(),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),

                        Forms\Components\Select::make('shipping_status')
                            ->options([
                                'pending' => 'Pending',
                                'packed' => 'Packed',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone'),



                Tables\Columns\TextColumn::make('courier')->badge(),

                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('shipping_cost')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),

                Tables\Columns\BadgeColumn::make('shipping_status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'packed',
                        'info' => 'shipped',
                        'success' => 'delivered',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                    ])
                    ->defaultSort('created_at', 'desc')
                    ->filters([])
                    
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
