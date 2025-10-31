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
        Schema::table('targets', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('fullname');  
            $table->string('kk_number', 16)->nullable()->after('nik');  
            $table->string('birth_place', 100)->nullable()->after('kk_number'); 
            $table->date('birth_date')->nullable()->after('birth_place'); 
            $table->string('phone_number', 15)->nullable()->after('birth_date'); 
            $table->string('target_classification')->nullable()->after('gender'); 
            $table->text('antecedents')->nullable()->after('target_classification');  
            $table->string('photo_path')->nullable()->after('antecedents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'kk_number',
                'birth_place',
                'birth_date',
                'phone_number',
                'target_classification',
                'antecedents',
                'photo_path',
            ]);
        });
    }
};
