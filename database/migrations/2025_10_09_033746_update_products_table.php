<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('products', 'qrcode')) {
                $table->string('qrcode')->nullable()->after('barcode');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('qrcode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['barcode', 'qrcode', 'image']);
        });
    }
};
