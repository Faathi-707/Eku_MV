<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disruption_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->text('cause');
            $table->string('clearance_period');
            $table->dateTime('clear_by')->nullable();
            $table->text('alternative_routes')->nullable();
            $table->text('other_info')->nullable();
            $table->string('affected_area')->nullable();
            $table->json('geojson')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disruption_reports');
    }
};
