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
        Schema::create('sso_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 64)->unique();
            $table->string('client_secret', 128);
            $table->string('name', 150);
            $table->string('code_name', 50)->unique(); // e.g. sim-jalan, si-irigasi, simbg, si-taru
            $table->text('description')->nullable();
            $table->string('app_url')->nullable();
            $table->text('redirect_uri');
            $table->string('icon_url')->nullable();
            $table->string('badge_color', 20)->default('#0F3B66');
            $table->string('bidang_terkait', 100)->nullable(); // e.g. Bina Marga, SDA, Cipta Karya
            $table->json('allowed_scopes')->nullable(); // ['profile', 'nip', 'bidang', 'kepegawaian']
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sso_clients');
    }
};

