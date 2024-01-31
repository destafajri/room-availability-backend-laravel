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
        Schema::create('facility_kosts', function (Blueprint $table) {
            $table->unsignedBigInteger('kost_id')->nullable(false);
            $table->unsignedBigInteger('facility_id')->nullable(false);
            $table->primary(['kost_id', 'facility_id']);
            $table->timestamps();

            $table->foreign('kost_id')->on('kosts')->references('id');
            $table->foreign('facility_id')->on('facilities')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_kosts');
    }
};
