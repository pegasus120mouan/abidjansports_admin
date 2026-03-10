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
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->string('ip_hash', 64); // IP hashée pour anonymisation
            $table->string('pays', 100)->nullable();
            $table->string('code_pays', 5)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('navigateur', 255)->nullable();
            $table->string('plateforme', 50)->nullable();
            $table->string('page_visitee', 500)->nullable();
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type_page', 50)->default('autre'); // article, boutique, accueil, categorie
            $table->timestamps();
            
            $table->index(['created_at']);
            $table->index(['ip_hash', 'created_at']);
            $table->index(['pays']);
            $table->index(['article_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
