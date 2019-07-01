<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('brand_id');
            $table->integer('subCategory_id');
            $table->integer('category_id');
            $table->string('name');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('list_price')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('best_sell')->default(0);
            $table->boolean('new_product')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('carousel')->default(0);
            $table->text('details')->nullable();
			$table->softDeletes();
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
