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
        Schema::create('mikrotik_devices', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('ip_address', 45);
            $table->unsignedSmallInteger('api_port')->default(8728);

            $table->string('username');
            $table->text('password');

            $table->string('location')->nullable();
            $table->text('description')->nullable();

            $table->string('routeros_version')->nullable();
            $table->string('board_name')->nullable();
            $table->string('architecture_name')->nullable();

            $table->enum('status', [
                'unchecked',
                'online',
                'offline',
            ])->default('unchecked');

            $table->timestamp('last_checked_at')->nullable();
            $table->text('last_error')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['ip_address', 'api_port']);
            $table->index('status');
            $table->index('last_checked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_devices');
    }
};
