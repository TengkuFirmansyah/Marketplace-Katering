<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('merchant_id');
            $table->uuid('customer_id');
            $table->string('kode');
            $table->date('tanggal');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps(0);
            $table->softDeletes('deleted_at');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('order_id');
            $table->uuid('merchant_menu_id');
            $table->integer('qty');
            $table->double('harga', 18, 0);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps(0);
            $table->softDeletes('deleted_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders'); 

    }
}        
        