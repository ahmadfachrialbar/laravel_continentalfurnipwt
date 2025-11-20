<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Data penerima
            $table->string('full_name')->nullable()->after('user_id');
            $table->string('phone')->nullable()->after('full_name');

            // Alamat detail
            $table->string('province_id')->nullable()->after('phone');
            $table->string('city_id')->nullable()->after('province_id');
            $table->string('district_id')->nullable()->after('city_id');
            $table->string('postal_code')->nullable()->after('district_id');

            // Info ongkir
            $table->integer('shipping_cost')->default(0)->after('shipping_address');
            $table->enum('shipping_status', ['calculated', 'manual'])
                ->default('manual')
                ->after('shipping_cost');
            $table->text('note_admin')-> default('cek ongkir manual')->nullable()->after('shipping_status');

            // Grand total (subtotal + ongkir)
            $table->integer('grand_total')->default(0)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'phone',
                'province_id',
                'city_id',
                'district_id',
                'postal_code',
                'shipping_cost',
                'shipping_status',
                'note_admin',
                'grand_total'
            ]);
        });
    }
};
