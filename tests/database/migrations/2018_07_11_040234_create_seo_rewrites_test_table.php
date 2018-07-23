<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoRewritesTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_rewrites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('source')->unique();
            $table->string('destination');

            $table->unique(['source', 'destination']);

            $table->unsignedSmallInteger('type')->default(301);

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
        Schema::dropIfExists('seo_rewrites');
    }
}
