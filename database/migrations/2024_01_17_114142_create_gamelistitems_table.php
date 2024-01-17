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
        Schema::create('gamelistitems', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('game_id')
                ->constrained(table: 'games', column: 'game_id',indexName: 'game_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreignId('user_id')
                ->constrained(table: 'users', column: 'user_id',indexName: 'user_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamelistitems');
    }
};
