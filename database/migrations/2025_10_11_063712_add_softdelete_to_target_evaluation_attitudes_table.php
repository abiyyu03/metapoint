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
        Schema::table('target_evaluation_attitudes', function (Blueprint $table) {
            if (!Schema::hasColumn('target_evaluation_attitudes', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_evaluation_attitudes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
