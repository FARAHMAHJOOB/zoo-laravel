<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('image')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('tags')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('animal_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('show_in_menu')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_categories');
    }
};
