<?php

declare(strict_types=1);

namespace Migrations;

use Migrations\BaseMigration;

class CreateProducts extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {

        $table = $this->table('products');

        $table
            //Name Column (String, Max 50 Characters, Not Nullable / Is Required
            ->addColumn('name', 'string', [
                  'limit' => 50,
                  'null' => false
            ])

            //Quantitiy Column (Integer, Max 4 digits, Not Nullable / Is Required, Default 0)
            ->addColumn('quantity', 'integer', [
                  'limit' => 4,
                  'null' => false,
                  'default' => 0
            ])

            //Price Column (Decimal, Total 7 Digits [Including after decimal],
            //Total 2 Decimal Places, Not Nullable / Is Required, Default 0)
            ->addColumn('price', 'decimal', [
                  'precision' => 7,
                  'scale' => 2,
                  'null' => false,
                  'default' => 0,
            ])

            //Deleted Column - for soft deletes. (Boolean, Default: False, Not Nullable / Is Required)
            ->addColumn('deleted', 'boolean', [
                  'default' => false,
                  'null' => false
            ])

            //Created Column (datetime, default to current, Not Nullable / Is Required)
            ->addColumn('created', 'datetime', [
                  'default' => 'CURRENT_TIMESTAMP',
                  'null' => false
            ])

            //Updated Column (datetime, no default, Is Nullable / Not Required)
            ->addColumn('updated', 'datetime', [
                  'default' => null,
                  'null' => true
            ])
            ->create();
    }
}
