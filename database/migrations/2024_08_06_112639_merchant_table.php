<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('merchant', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('user_id');
            $table->string('nama');
            $table->string('alamat');
            $table->string('kontak');
            $table->text('deskripsi');
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
        Schema::dropIfExists('merchant'); 

    }
}        
        