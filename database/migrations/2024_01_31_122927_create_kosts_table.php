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
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable(false);
            $table->string('kost_name')->unique('kost_name_unique')->nullable(false);
            $table->string('description')->nullable(true);
            $table->string('address')->nullable(false);
            $table->double('price')->nullable(false)->default(0);
            $table->integer('room_total')->nullable(false);
            $table->integer('room_available')->nullable(false)->default(0);
            $table->boolean('is_active')->nullable(false)->default(true);
            $table->timestamps();

            $table->foreign('owner_id')
                ->on('owners')
                ->references('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
