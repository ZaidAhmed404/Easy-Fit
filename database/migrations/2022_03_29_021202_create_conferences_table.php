<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string("conferenceName",80);
            $table->string("acronym",20);
            $table->date("startingDate");
            $table->date("endingDate");
            $table->string("contactEmail",80);
            $table->string("venue",80);
            $table->string("Country",80);
            $table->string("primaryAim",80);
            $table->string("secondaryAim",80);
            $table->string("estimatedSubmissions",10); 
            $table->string("organizerPhoneNumber",20);   
            $table->string("web",80);
            $table->unsignedBigInteger("userId");
            $table->string("approved",30);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('conferences');
    }
}
