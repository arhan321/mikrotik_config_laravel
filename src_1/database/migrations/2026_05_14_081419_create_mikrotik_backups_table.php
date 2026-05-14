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
        Schema::create('mikrotik_backups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mikrotik_device_id')
                ->nullable()
                ->constrained('mikrotik_devices')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('backup_name');

            /*
             * export = /export file=...
             * backup = /system backup save name=...
             */
            $table->enum('backup_type', [
                'export',
                'backup',
            ])->default('export');

            $table->enum('status', [
                'pending',
                'running',
                'success',
                'failed',
            ])->default('pending');

            /*
             * Path file backup di storage Laravel.
             *
             * Contoh:
             * mikrotik-backups/MTK-LAB-01/backup-2026-05-14.rsc
             */
            $table->string('backup_path')->nullable();

            /*
             * Kalau nanti kamu mau simpan isi export langsung ke DB.
             */
            $table->longText('backup_content')->nullable();

            $table->unsignedBigInteger('file_size')->nullable();

            $table->text('error_message')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            $table->index('backup_type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_backups');
    }
};