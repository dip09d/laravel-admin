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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // menu label
            $table->string('slug')->unique(); // permission name (link to Spatie)
            $table->string('url')->nullable(); // route/url for sidebar
            $table->string('icon_class')->nullable();
            $table->unsignedBigInteger('parent_id')->default(0); // for submenus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
