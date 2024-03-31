<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id("task_id");
            $table->string("task_title");
            $table->string("description");
            $table->boolean("completed")->default(false);
            $table->string("priority"); 
            $table->string("content");
            $table->dateTime("due_date")->nullable();
            $table->unsignedBigInteger("tag_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->timestamps();
            $table->foreign("tag_id")->references("tag_id")->on('tags')->onDelete('cascade');
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
