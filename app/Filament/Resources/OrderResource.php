<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;


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


                    ])
                    ->columns(2),

                Forms\Components\Section::make('Produk Info')
                    ->schema([
                        Repeater::make('orderItems')
                            ->relationship('orderItems')  // relasi orderItems
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')  // Relasi ke Product
                                    ->searchable()
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->defaultItems(1),
                    ]),

                Forms\Components\Section::make('Shipping')
                    ->schema([
                        // PROVINCE SELECT
                        Forms\Components\Select::make('province_id')
                            ->label('Province')
                            ->relationship('province', 'name')
                            ->searchable(),

                        // CITY SELECT
                        Forms\Components\Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->searchable(),

                        // DISTRICT SELECT
                        Forms\Components\Select::make('district_id')
                            ->label('District')
                            ->relationship('district', 'name')
                            ->searchable(),

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
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ])
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->sortable(),

                Tables\Columns\SelectColumn::make('shipping_status')
                    ->label('Status Pengiriman')
                    ->options([
                        'pending' => 'Pending',
                        'packed' => 'Packed',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItems')
                    ->label('Produk')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->map(function ($item) {
                            return $item->product->name . ' (Qty: ' . $item->quantity . ', Price: Rp ' . number_format($item->price, 0, ',', '.') . ')';
                        })->join(', ');
                    })
                    ->wrap()
                    ->limit(15),

                Tables\Columns\TextColumn::make('courier')
                    ->badge()
                    ->label('Kurir'),

                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('Ongkir')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')


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
