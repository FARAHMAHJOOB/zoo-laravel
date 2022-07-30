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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->string('scntf_name')->nullable()->comment('scientific name');
            $table->text('summary')->nullable();
            $table->text('description');
            $table->foreignId('category_id')->constrained('animal_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('protective_id')->nullable()->constrained('animal_protective_status')->onUpdate('cascade')->onDelete('cascade');
            $table->string('height')->nullable()->comment('cm unit');
            $table->string('weight')->nullable()->comment('kg unit');
            $table->text('threatening_factors')->nullable();
            $table->text('habitat')->nullable();
            $table->text('image')->nullable();
            $table->string('tags')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->integer('views')->default(0);
            $table->tinyInteger('show_in_menu')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamp('published_at');
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
        Schema::dropIfExists('animals');
    }
};
