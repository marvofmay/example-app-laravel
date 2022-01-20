<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('description')->nullable();
                $table->string('slug', 250);
                $table->foreignIdFor(Category::class);
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
        Schema::dropIfExists('product');
    }
}
