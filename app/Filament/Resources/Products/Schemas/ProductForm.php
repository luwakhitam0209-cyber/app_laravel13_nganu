<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('store_id')
                    ->required()
                    ->numeric(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('stock')
                    ->required()
                    ->numeric(),

                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048),
            ]);
    }
}