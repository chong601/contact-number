<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->timestamps();
        });
        
        DB::table('category')->insert(
            [
                ['category_name' => 'Family'],
                ['category_name' => 'Friend'],
                ['category_name' => 'Work'],
            ]
        );

        Schema::create('category_contact_mapping', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->bigInteger('contact_id');
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('contact_id')->references('id')->on('contacts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
        Schema::dropIfExists('category_code_mapping');
    }
}
