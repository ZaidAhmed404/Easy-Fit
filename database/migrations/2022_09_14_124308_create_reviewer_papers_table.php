<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("PaperId");
            $table->unsignedBigInteger("reviewerId");
            $table->unsignedBigInteger("trackId");
            $table->unsignedBigInteger("conferenceId");
            $table->string("status",15);
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paperId')->references('id')->on('papers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('trackId')->references('id')->on('tracks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('conferenceId')->references('id')->on('conferences')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('reviewer_papers');
    }
}
