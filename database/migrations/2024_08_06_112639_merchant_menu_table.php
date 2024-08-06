<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MerchantMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('merchant_menu', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('merchant_id');
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('foto');
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
        Schema::dropIfExists('merchant_menu'); 

    }
}        
        