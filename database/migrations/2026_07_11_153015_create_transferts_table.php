<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->unique();
            $table->foreignId('dossier_id')->constrained();
            $table->json('nouveaux_clients');
            $table->string('document_path')->nullable();
            $table->foreignId('transfere_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferts');
    }
}