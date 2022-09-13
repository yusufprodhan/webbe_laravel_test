<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('cinema', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('user_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('booked')->default(0); //0 for can  book and 1 for book out
            $table->string('name')->unique();
            $table->double("price",10,2);
            $table->integer("total_capacity");
            $table->double("offer_price",10,2)->nullable();
            $table->integer("discount")->nullable();
            $table->date('release')->nullable();
            $table->year("release_year");
            $table->string('location')->nullable();
            $table->string('summary')->nullable();
            $table->string('logo')->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('seat_id')->unsigned();
            $table->dateTime('reserved_slot');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seat')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('seat', function (Blueprint $table) {
            $table->id();
            $table->enum('seat_type',['VIP','COUPLE','SUPER_VIP','GENERAL','OTHERS']);
            $table->integer('count');
            $table->string('position');
            $table->integer('cinema_id')->unsigned();
            $table->foreign('cinema_id')->references('id')->on('cinema')->onDelete('cascade');
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
        Schema::dropIfExists('cinema');
        Schema::dropIfExists('booking');
    }
}
