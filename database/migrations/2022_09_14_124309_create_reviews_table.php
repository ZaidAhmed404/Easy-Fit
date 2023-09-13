<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("reviewerId");
            $table->unsignedBigInteger("paperId");
            $table->unsignedBigInteger("trackId");
            $table->unsignedBigInteger("conferenceId");
            $table->unsignedBigInteger("paperReviewerId");
            $table->string("evaluation",30);
            $table->string("confident",30);
            $table->string("review",1000);
            $table->string("reviewForReviewers",1000);
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('trackId')->references('id')->on('tracks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paperId')->references('id')->on('papers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('conferenceId')->references('id')->on('conferences')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paperReviewerId')->references('id')->on('reviewer_papers')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('reviews');
    }
}
