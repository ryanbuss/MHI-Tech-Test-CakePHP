<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Apple Juice',
                'quantity' => 50,
                'price' => 4.99,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 2,
                'name' => 'Orange Juice',
                'quantity' => 0,
                'price' => 3.49,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 3,
                'name' => 'Premium Coffee',
                'quantity' => 100,
                'price' => 120.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 4,
                'name' => 'Basic Coffee',
                'quantity' => 5,
                'price' => 10.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 5,
                'name' => 'Promo Tea',
                'quantity' => 20,
                'price' => 30.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 6,
                'name' => 'Promo Honey',
                'quantity' => 0,
                'price' => 40.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 7,
                'name' => 'Mineral Water',
                'quantity' => 200,
                'price' => 1.50,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 8,
                'name' => 'Organic Milk',
                'quantity' => 30,
                'price' => 15.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 9,
                'name' => 'Chocolate Bar',
                'quantity' => 300,
                'price' => 2.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ],
            [
                'id' => 10,
                'name' => 'Luxury Chocolate',
                'quantity' => 10,
                'price' => 500.00,
                'deleted' => 0,
                'created' => '2025-01-16 18:21:14',
                'updated' => null,
            ]
        ];
        parent::init();
    }
}
