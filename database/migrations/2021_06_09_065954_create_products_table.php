<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');
            $table->string('domain', 250)->unique();
            $table->string('url', 250)->unique();
            $table->string('name', 250);
            $table->string('trello', 250);
            $table->string('color', 250)->nullable();
            $table->text('description')->nullable();
            $table->text('info')->nullable();
            $table->string('type', 250);
            $table->integer('template')->default(1);
            $table->integer('sale');
            $table->integer('count');
            $table->float('price');
            $table->float('old_price');
            $table->integer('contact_type')->default(0);
            $table->string('head_image', 250);
            $table->string('footer_image', 250);
            $table->string('footer_name', 250);
            $table->string('youtube', 250)->nullable();
            $table->string('alert_1', 250)->nullable();
            $table->string('alert_2', 250)->nullable();
            $table->string('alert_3', 250)->nullable();
            $table->string('alert_4', 250)->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
