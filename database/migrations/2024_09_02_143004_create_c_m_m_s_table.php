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
        Schema::create('c_m_m_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('number')->unique();
            $table->string('title')->nullable();
            $table->string('img')->nullable();
            $table->date('revision_date')->nullable();
            $table->string('lib')->nullable();
            $table->boolean('active')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_m_m_s');
    }
};
