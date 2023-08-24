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
        Schema::create('stage_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->string('task_status')->comment('0=assigned,1=started,2=working,3=completed,4=rejected')->default(0);
            $table->string('stage_status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('reason_description')->nullable();
            $table->json('attachments')->nullable(); // Define the 'attachments' column
            $table->string('attachment_title')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Define foreign key constraint for task_id column
            $table->foreign('task_id')->references('task_id')->on('tasks')->onDelete('cascade');
            
            // Define foreign key constraint for user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stage_tracks');
    }
};
