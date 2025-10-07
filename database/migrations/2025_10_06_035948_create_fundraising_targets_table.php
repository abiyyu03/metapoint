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
        Schema::create('fundraising_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("target_id");
            $table->string("type");
            $table->string("unit");
            $table->string("amount_unit");
            $table->foreignId("method_id");
            $table->foreignId("method_option_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraising_targets');
    }
};
