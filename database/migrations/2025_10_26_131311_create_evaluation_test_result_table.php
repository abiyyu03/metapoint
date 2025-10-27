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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // user operator yang mengisi
            $table->foreignId('target_id'); // target  
            $table->foreignId('agent_id'); // agent  
            $table->timestamp('issued_at')->default(now());
            $table->timestamps();
            $table->softDeletes();
        });

        // just master for section title
        Schema::create('assessment_result_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        // list of result
        Schema::create('assessment_result_part_ones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id');
            $table->foreignId('assessment_result_section_id');
            $table->enum('result_type', ['table', 'essay']);
            $table->string('value');
            $table->string('index')->nullable();
            $table->foreignId('question_variable_id')->nullable(); // only filed on table type
            $table->string('result_category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('assessment_result_part_twos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id');
            $table->foreignId('assessment_result_section_id');
            $table->enum('result_type', ['table', 'diagram']);
            $table->foreignId('question_variable_id');
            $table->integer('value');
            $table->string('result_category');
            $table->timestamps();
            $table->softDeletes();
        });
        // Table: question_answers
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id');
            $table->foreignId('question_id');
            $table->foreignId('answer_id')->nullable(); // untuk opsi choice
            $table->text('answer_value')->nullable(); // untuk essay / skor manual
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_result_sections');
        Schema::dropIfExists('assessment_result_part_ones');
        Schema::dropIfExists('assessment_result_part_twos');
        Schema::dropIfExists('assessment_results');
        Schema::dropIfExists('question_answers');
    }
};
