<?php

declare(strict_types=1);

namespace Migrations;

use Migrations\BaseSeed;

/**
 * Products seed.
 */
class ProductsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Apple Juice', 'quantity' => 50, 'price' => 4.99],
            ['name' => 'Orange Juice', 'quantity' => 0, 'price' => 3.49],
            ['name' => 'Premium Coffee', 'quantity' => 100, 'price' => 120.00],
            ['name' => 'Basic Coffee', 'quantity' => 5, 'price' => 10.00],
            ['name' => 'Promo Tea', 'quantity' => 20, 'price' => 30.00],
            ['name' => 'Promo Honey', 'quantity' => 0, 'price' => 40.00],
            ['name' => 'Mineral Water', 'quantity' => 200, 'price' => 1.50],
            ['name' => 'Organic Milk', 'quantity' => 30, 'price' => 15.00],
            ['name' => 'Chocolate Bar', 'quantity' => 300, 'price' => 2.00],
            ['name' => 'Luxury Chocolate', 'quantity' => 10, 'price' => 500.00],
        ];

        //Insert data into the 'products' table
        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
