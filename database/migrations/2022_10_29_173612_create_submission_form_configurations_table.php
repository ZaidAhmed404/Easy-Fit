<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionFormConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_form_configurations', function (Blueprint $table) {
            $table->id();
            $table->string("requirePostalAddress",10);
            $table->string("preSubmissionAllowed",10);
            $table->string("disableAbstract",10);
            $table->string("disableMultipleAuthors",10);
            $table->string("fileUpload",10);
            $table->string("presenterSelected",10);
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
        Schema::dropIfExists('submission_form_configurations');
    }
}
