<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExcelFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('file_name');
            $table->enum('type', ['grades', 'applicants']);
            $table->integer('created_rows')->default(0);
            $table->integer('updated_rows')->default(0);
            $table->enum('progress_status', ['New', 'Uploading', 'Completed', 'Failed'])->default('New');
            $table->longText('log_errors')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excel_files');
    }
}
