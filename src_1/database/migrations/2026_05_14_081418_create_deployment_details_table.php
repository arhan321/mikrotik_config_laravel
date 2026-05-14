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
        Schema::create('deployment_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('deployment_id')
                ->constrained('deployments')
                ->cascadeOnDelete();

            $table->foreignId('mikrotik_device_id')
                ->nullable()
                ->constrained('mikrotik_devices')
                ->nullOnDelete();

            $table->enum('status', [
                'pending',
                'running',
                'success',
                'failed',
                'skipped',
            ])->default('pending');

            /*
             * Command final yang sudah diganti variable.
             *
             * Contoh:
             * /system identity set name=MTK-LAB-01
             */
            $table->longText('command_sent')->nullable();

            /*
             * Response dari MikroTik.
             */
            $table->longText('response_message')->nullable();

            /*
             * Pesan error kalau gagal.
             */
            $table->longText('error_message')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->unsignedBigInteger('duration_ms')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployment_details');
    }
};
