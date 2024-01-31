<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('facility_kosts', function (Blueprint $table) {
            $table->dropForeign(['kost_id']);

            $table->foreign('kost_id')->references('id')->on('kosts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_kosts', function (Blueprint $table) {
            $table->dropForeign(['kost_id']);

            $table->foreign('kost_id')->references('id')->on('kosts');
        });
    }
};
