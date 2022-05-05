<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\ItemFactory;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemFactory = new ItemFactory(100);
        $itemFactory->create();
    }
}
