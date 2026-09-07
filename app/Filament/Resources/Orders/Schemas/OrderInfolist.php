<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =========================
                // INFORMASI PESANAN
                // =========================
                Section::make('Informasi Pesanan')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Nomor Order')
                            ->formatStateUsing(
                                fn ($state) => '#ORD-' . $state
                            ),

                        TextEntry::make('status')
                            ->label('Status Pembayaran')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'failed' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('user.name')
                            ->label('Pembeli')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Tanggal Pesanan')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),

                // =========================
                // PRODUK DIPESAN
                // =========================
                Section::make('Produk Dipesan')
                    ->schema([
                        RepeatableEntry::make('details')
                            ->label('')
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Produk')
                                    ->weight('bold'),

                                TextEntry::make('quantity')
                                    ->label('Jumlah'),

                                TextEntry::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->money('IDR'),

                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->state(
                                        fn ($record) =>
                                            $record->unit_price *
                                            $record->quantity
                                    )
                                    ->money('IDR'),
                            ])
                            ->columns(4),
                    ])
                    ->columnSpanFull(),

                // =========================
                // INFORMASI PENGIRIMAN
                // =========================
                Section::make('Informasi Pengiriman')
                    ->schema([
                        TextEntry::make('shipping_destination')
                            ->label('Tujuan Pengiriman')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('shipping_courier')
                            ->label('Kurir')
                            ->formatStateUsing(
                                fn ($state) =>
                                    strtoupper($state ?? '-')
                            ),

                        TextEntry::make('shipping_service')
                            ->label('Layanan')
                            ->placeholder('-'),

                        TextEntry::make('shipping_cost')
                            ->label('Ongkos Kirim')
                            ->money('IDR'),
                    ])
                    ->columns(2),

                // =========================
                // RINGKASAN PEMBAYARAN
                // =========================
                Section::make('Ringkasan Pembayaran')
                    ->schema([
                        TextEntry::make('payment.amount')
                            ->label('Total Pembayaran')
                            ->money('IDR')
                            ->weight('bold')
                            ->size('lg'),

                        TextEntry::make('payment.method')
                            ->label('Metode Pembayaran')
                            ->formatStateUsing(
                                fn ($state) =>
                                    ucfirst($state ?? '-')
                            ),
                    ])
                    ->columns(2),

            ]);
    }
}