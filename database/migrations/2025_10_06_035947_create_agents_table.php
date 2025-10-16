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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string("fullname");
            $table->integer("age")->default(0);
            $table->enum("gender", ["L", "P"]);
            $table->foreignId("organization_id")->nullable();
            $table->foreignId("title_id")->nullable();
            $table->text("address")->nullable();
            $table->foreignId("village_id");
            $table->foreignId("district_id");
            $table->foreignId("city_id");
            $table->foreignId("province_id");
            $table->foreignId("country_id");
            $table->float("lat");
            $table->float("lng");
            $table->foreignId("operational_unit_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
