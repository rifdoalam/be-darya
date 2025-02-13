<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Foreign key to the 'obats' table
            $table->unsignedBigInteger('obat_id');
            $table->foreign('obat_id')->references('id')->on('obats')->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('status',['pending', 'approved_admin', 'approved_distributor', 'rejected']);
            $table->date('request_date');
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
        Schema::dropIfExists('request_obats');
    }
};
