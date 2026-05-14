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
        Schema::create('device_variables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mikrotik_device_id')
                ->constrained('mikrotik_devices')
                ->cascadeOnDelete();

            /*
             * Key variable.
             *
             * Contoh:
             * router_name
             * dns_server
             * ip_address
             * interface
             * wan_interface
             */
            $table->string('variable_key');

            /*
             * Value variable.
             *
             * Contoh:
             * MTK-LAB-01
             * 8.8.8.8,1.1.1.1
             * 192.168.88.1/24
             * ether1
             */
            $table->text('variable_value')->nullable();

            /*
             * Kalau nanti ada variable sensitif,
             * misalnya password PPPoE, bisa ditandai secret.
             */
            $table->boolean('is_secret')->default(false);

            $table->timestamps();

            $table->unique(['mikrotik_device_id', 'variable_key'], 'device_variable_unique');
            $table->index('variable_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_variables');
    }
};
