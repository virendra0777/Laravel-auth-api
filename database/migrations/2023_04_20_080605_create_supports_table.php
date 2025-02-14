<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('_id')->on('users')->onDelete('cascade');
            $table->string('subject',100);
            $table->string('message',200);
            $table->enum('isreply',[1,0])->comment('1 => yes, 0 => no');
            $table->enum('status',[1,0])->comment('1 => resolved, 0 => pending');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supports');
    }
}
