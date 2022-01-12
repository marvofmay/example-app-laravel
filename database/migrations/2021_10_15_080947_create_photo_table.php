<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class CreatePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'photo', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('filepath')->nullable();
                $table->foreignIdFor(Product::class);
                $table->boolean('main')->default(false);
                $table->boolean('active')->default(true);
                $table->boolean('deleted')->default(false);            
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo');
    }
}
