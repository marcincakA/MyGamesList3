<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('developer')->nullable()->default(null)->change();
            $table->string('publisher')->nullable()->default(null)->change();
            $table->string('category1')->nullable()->default(null)->change();
            $table->string('category2')->nullable()->default(null)->change();
            $table->string('category3')->nullable()->default(null)->change();
            $table->longText('about')->nullable()->default(null)->change();
            $table->string('image')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('developer')->change();
            $table->string('publisher')->change();
            $table->string('category1')->change();
            $table->string('category2')->change();
            $table->string('category3')->change();
            $table->longText('about')->change();
            $table->string('image')->change();
        });
    }
};
