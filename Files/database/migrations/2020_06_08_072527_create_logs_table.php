<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->string('type');
            $table->string('result')->nullable();
            $table->unsignedBigInteger('server_id');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('logs');
    }
}
