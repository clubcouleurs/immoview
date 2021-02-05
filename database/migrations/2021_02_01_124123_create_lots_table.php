<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('nombreFacadesLot');
            $table->float('surfaceLot');
            $table->tinyInteger('nombreEtagesLot');
            $table->string('typeLot');
            $table->string('descriptionLot')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('idProduit');

        });

            Schema::table('lots', function (Blueprint $table) {
            $table->foreign('idProduit')->references('id')->on('produits');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
