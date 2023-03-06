<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('product_log', function (Blueprint $table) {
                $table->id();
                $table->text('changes');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('updated_by');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('product_log');
    }
}
