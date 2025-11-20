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
            // Drop kolom duplikat yang tidak diperlukan (pastikan data sudah backup jika ada)
            $table->dropColumn('address');  // Drop address lama, gunakan shipping_address
            $table->dropColumn('total_price');  // Drop total_price, gunakan subtotal
            $table->dropColumn('grand_total');  // Drop grand_total, gunakan total

            // Rename kolom yang tersisa ke nama yang konsisten
            $table->renameColumn('shipping_address', 'address');  // shipping_address -> address
            // subtotal sudah ada, tidak perlu rename
            // total sudah ada, tidak perlu rename
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse: Rename kembali dan recreate kolom yang didrop (jika rollback)
            $table->renameColumn('address', 'shipping_address');
            $table->text('address')->nullable();  // Recreate address
            $table->decimal('total_price', 15, 2)->nullable();  // Recreate total_price
            $table->decimal('grand_total', 15, 2)->nullable();  // Recreate grand_total
        });
    }
};