<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string("Title",250)->nullable();
            $table->string("Abstract",10000);
            $table->string("tags",500)->nullable();
            $table->string("PaperFileName",10)->nullable();
            $table->unsignedBigInteger('trackId');
            $table->unsignedBigInteger('conferenceId');
            $table->unsignedBigInteger('submittedBy');
            $table->string('decision',30);
            $table->foreign('submittedBy')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('conferenceId')->references('id')->on('conferences')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('trackId')->references('id')->on('tracks')->onDelete('cascade')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers');
    }
}
