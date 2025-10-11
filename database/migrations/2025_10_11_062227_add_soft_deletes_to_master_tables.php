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
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('titles', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('issues', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('intelligent_methods', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('intelligent_method_options', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('target_evaluation_attitudes', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('titles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('issues', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('intelligent_methods', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('intelligent_method_options', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('target_evaluation_attitudes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
