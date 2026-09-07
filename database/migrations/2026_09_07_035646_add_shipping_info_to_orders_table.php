<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('shipping_cost')
                ->default(0)
                ->after('status');

            $table->string('shipping_destination')
                ->nullable()
                ->after('shipping_cost');

            $table->string('shipping_courier')
                ->nullable()
                ->after('shipping_destination');

            $table->string('shipping_service')
                ->nullable()
                ->after('shipping_courier');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_cost',
                'shipping_destination',
                'shipping_courier',
                'shipping_service',
            ]);
        });
    }
};