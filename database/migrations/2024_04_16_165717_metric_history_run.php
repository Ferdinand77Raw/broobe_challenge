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
        Schema::create('metric_history_run', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('accesibility_metric');
            $table->string('pwa_metric');
            $table->string('performance_metric');
            $table->string('seo_metric');
            $table->string('best_practices_metric');
            $table->unsignedBigInteger('strategy_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metric_history_run');
    }
};
