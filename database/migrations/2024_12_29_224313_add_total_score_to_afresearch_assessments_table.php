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
        Schema::table('research_assessments', function (Blueprint $table) {
            $table->integer('total_score')->after('methodology_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('afresearch_assessments', function (Blueprint $table) {
            $table->dropColumn('total_score');
        });
    }
};
