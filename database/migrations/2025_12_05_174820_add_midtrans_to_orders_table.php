<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'order_id_midtrans')) {
            $table->string('order_id_midtrans')->nullable()->after('id');
        }
        // payment_status sudah ada, jadi tidak usah ditambah
    });
    }

    public function down()
    {
    Schema::table('orders', function (Blueprint $table) {
        if (Schema::hasColumn('orders', 'order_id_midtrans')) {
            $table->dropColumn('order_id_midtrans');
        }
        // payment_status jangan dihapus karena sudah ada sebelumnya
    });
    }


};
