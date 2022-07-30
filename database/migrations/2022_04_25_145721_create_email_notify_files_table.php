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
        Schema::create('email_notify_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained('email_notify')->onUpdate('cascade')->onDelete('cascade');
            $table->text('file_path');
            $table->bigInteger('file_size');
            $table->string('file_type');
            $table->tinyInteger('storage')->default(0)->comment('0=>save in public folder , 1=>save in storage folder');
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
        Schema::dropIfExists('email_notify_files');
    }
};
