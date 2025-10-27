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
        // Table: assessment_identifications
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //bagian I - asesmen penggalang, bagian II - Profiling target penggalang
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Table: assessment_titles
        Schema::create('assessment_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id');
            $table->text('description')->nullable();
            $table->string('name'); // narasi ideologi, narasi aksi radikal, kebutuhan fisiologis, kebutuhan rasa aman
            $table->integer('order')->default(0); //urutan pertanyaan
            $table->timestamps();
            $table->softDeletes();
        });

        // Table: questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_section_id');
            $table->foreignId('question_variable_id');
            $table->text('value'); // pertanyaan: apa itu pancasila menurut kamu
            $table->enum('type', ['choice', 'essay']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Table: question categories
        Schema::create('question_variables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dimension');
            $table->timestamps();
            $table->softDeletes();
        });

        // Table: answers
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->string('label_option')->nullable(); // ex : a, b, c, 1,2 ,dst
            $table->integer('order')->default(0); //urutan jawaban
            $table->string('label')->nullable();
            $table->integer('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('assessment_sections');
        Schema::dropIfExists('assessments');
        Schema::dropIfExists('question_variables');
    }
};