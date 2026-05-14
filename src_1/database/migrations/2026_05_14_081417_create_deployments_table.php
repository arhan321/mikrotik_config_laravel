<?php

declare(strict_types=1);

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
        Schema::create('deployments', function (Blueprint $table) {
            $table->id();

            $table->string('deployment_code')->unique();

            $table->foreignId('configuration_template_id')
                ->nullable()
                ->constrained('configuration_templates')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('mode', [
                'single',
                'bulk',
            ])->default('single');

            $table->enum('status', [
                'pending',
                'running',
                'success',
                'partial_success',
                'failed',
                'cancelled',
            ])->default('pending');

            $table->unsignedInteger('total_devices')->default(0);
            $table->unsignedInteger('success_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->unsignedBigInteger('duration_ms')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('mode');
            $table->index('status');
            $table->index('started_at');
            $table->index('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployments');
    }
};
