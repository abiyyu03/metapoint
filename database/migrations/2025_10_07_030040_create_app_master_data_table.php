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

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('intelligent_methods', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('intelligent_method_options', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("intelligent_method_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('target_evaluation_attitudes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('titles');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('intelligent_methods');
        Schema::dropIfExists('intelligent_method_options');
        Schema::dropIfExists('target_evaluation_attitudes');
    }
};
