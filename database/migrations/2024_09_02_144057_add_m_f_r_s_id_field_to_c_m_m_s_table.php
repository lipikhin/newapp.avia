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
        Schema::table('c_m_m_s', function (Blueprint $table) {
            $table->foreignId('m_f_r_s_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('c_m_m_s', function (Blueprint $table) {
            $table->dropColumn(['m_f_r_s_id']);
        });
    }
};
