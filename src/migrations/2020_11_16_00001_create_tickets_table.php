<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laravel-tickets.tickets-table'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('label_id')->nullable();
            $table->string('subject');
            $table->enum('priority', config('laravel-tickets.priorities'));
            $table->enum('state', ['OPEN', 'ANSWERED', 'CLOSED'])->default('OPEN');
            $table->timestamps();

            if (!config('laravel-tickets.models.uuid')) {
                $table->foreign('user_id')
                    ->on(config('laravel-tickets.users-table'))->references('id');
                $table->foreign('category_id')
                    ->on(config('laravel-tickets.ticket-categories-table'))->references('id');
                $table->foreign('label_id')
                    ->on(config('laravel-tickets.ticket-labels-table'))->references('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('laravel-tickets.tickets-table'));
    }
}
