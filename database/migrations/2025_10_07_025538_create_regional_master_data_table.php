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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("district_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("city_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("province_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->nullable();
            $table->foreignId("country_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('countries');
    }
};
