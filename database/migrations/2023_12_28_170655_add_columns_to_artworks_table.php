<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToArtworksTable extends Migration
{
    public function up()
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('image_path');
            $table->string('title');
            $table->text('description');
        });
    }

    public function down()
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'title', 'description']);
        });
    }
}
