<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')->default(true);
            $table->string('number')->unique();
            $table->double('balance')->default(0);
            $table->datetimeTz('created_at')->nullable();
            $table->datetimeTz('updated_at')->nullable();
        });

        Schema::create('purposes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->integer('purpose_id')->unsigned();

            $table->boolean('is_incoming')->default(false);
            $table->integer('status')->default(0);

            $table->string('title');
            $table->string('description');
            $table->decimal('amount', 15, 2)->default(0);

            $table->datetimeTz('created_at')->nullable();
            $table->datetimeTz('completed_at')->nullable();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('purpose_id')->references('id')->on('purposes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('transactions');
        Schema::dropIfExists('purposes');
        Schema::dropIfExists('accounts');

        Schema::enableForeignKeyConstraints();
    }
}
