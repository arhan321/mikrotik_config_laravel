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
        Schema::create('configuration_templates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();

            $table->text('description')->nullable();

            /*
             * Isi command template.
             *
             * Contoh:
             * /system identity set name={{router_name}}
             * /ip dns set servers={{dns_server}} allow-remote-requests=yes
             */
            $table->longText('script_content');

            /*
             * Daftar variable hasil deteksi dari script_content.
             *
             * Contoh:
             * ["router_name", "dns_server", "ip_address", "interface"]
             */
            $table->json('variables')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_templates');
    }
};
