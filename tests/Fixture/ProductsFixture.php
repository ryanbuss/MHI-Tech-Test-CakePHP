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
                'name' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'price' => 1.5,
                'deleted' => 1,
                'created' => '2025-01-16 18:53:21',
                'updated' => '2025-01-16 18:53:21',
            ],
        ];
        parent::init();
    }
}
