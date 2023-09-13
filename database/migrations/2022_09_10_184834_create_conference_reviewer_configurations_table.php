<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferenceReviewerConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conference_reviewer_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('model',10);
            $table->string('allowReviews',10);
            $table->string('showReviewerNames',10);
            $table->string('showAuthorsNames',10);
            $table->string('allowSubreviews',10);
            $table->string('allowStatusMenu',10);

            $table->string('allowTrackchairStatusMenu',10);
            $table->string('reviewsAccess',10);
            $table->string('allowAttachment',10);
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
        Schema::dropIfExists('conference_reviewer_configurations');
    }
}
