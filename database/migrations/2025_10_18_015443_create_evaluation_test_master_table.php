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
        // Table: assesment_identifications
        Schema::create('assesments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //bagian I - asesmen penggalang, bagian II - Profiling target penggalang
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Table: assesment_titles
        Schema::create('assesment_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assesment_id');
            $table->string('name'); // narasi ideologi, narasi aksi radikal, kebutuhan fisiologis, kebutuhan rasa aman
            $table->integer('order')->default(0); //urutan pertanyaan
            $table->timestamps();
        });

        // Table: questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assesment_section_id');
            $table->text('value'); // pertanyaan: apa itu pancasila menurut kamu
            $table->enum('type', ['choice', 'essay']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
        });

        // Table: question_answers
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // user yang mengisi
            $table->foreignId('question_id');
            $table->foreignId('answer_id')->nullable(); // untuk opsi choice
            $table->text('answer_value')->nullable(); // untuk essay / skor manual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('assesment_sections');
        Schema::dropIfExists('assesments');
    }
};
