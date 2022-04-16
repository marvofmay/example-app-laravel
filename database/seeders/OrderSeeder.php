<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\OrderFactory;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        $orderFactory = new OrderFactory(45);
        $orderFactory->create();
    }
}
