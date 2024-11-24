<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('percent');
            $table->timestamp('expired_at');
            $table->timestamps();

        /* to add another col without rolling back the table or migration =>
            1) make a migration in terminal like => php artisan module:make-migration add_expired_col_to_discount_table Discount
            2) then in that new migration add only the col you want to be added in specific table.
            3) dont forget to add table's name too in the new migration
        */
        });

        Schema::create('discount_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->unique(['user_id', 'discount_id']);
        });

        Schema::create('discount_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->unique(['product_id', 'discount_id']);
        });

        Schema::create('category_discount', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->unique(['category_id', 'discount_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_discount');
        Schema::dropIfExists('discount_product');
        Schema::dropIfExists('discount_user');
        Schema::dropIfExists('discounts');
    }
};
