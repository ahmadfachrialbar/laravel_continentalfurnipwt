<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom alamat yang benar
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }

            // Tambah kurir
            if (!Schema::hasColumn('orders', 'courier')) {
                $table->string('courier')->nullable()->after('district_id');
            }

            // Tambah berat
            if (!Schema::hasColumn('orders', 'weight')) {
                $table->integer('weight')->default(0)->after('courier');
            }

            // Subtotal belanja (harga barang)
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->integer('subtotal')->default(0)->after('weight');
            }

            // Total akhir (subtotal + ongkir)
            if (!Schema::hasColumn('orders', 'total')) {
                $table->integer('total')->default(0)->after('subtotal');
            }

            // Tambah status
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('total');
            }

            // Tambah status pembayaran
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'courier',
                'weight',
                'subtotal',
                'total',
                'status',
                'payment_status'
            ]);
        });
    }
};
