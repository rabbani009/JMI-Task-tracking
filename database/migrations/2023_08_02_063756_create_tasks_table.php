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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_id', 6)->unique();
            $table->string('task_title');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sbu_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('remarks')->nullable();;
            $table->string('p_type');
            $table->string('p_class');
            $table->json('a_office');
            $table->json('task_approved_steps'); //

            $table->unsignedTinyInteger('status')->comment('0=Inactive,1=Active')->default(1);
            $table->unsignedTinyInteger('task_status')->comment('0=assigned,1=started,2=working,3=completed,4=rejected')->default(0);

            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();

            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();


            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sbu_id')->references('id')->on('sbus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
