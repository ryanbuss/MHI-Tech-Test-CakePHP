<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductsController Test Case
 *
 * @uses \App\Controller\ProductsController
 */
class ProductsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Products',
    ];

    /**
     * Test Delete Product Method
     *
     * Verifies that product with ID 1 is not initially deleted ('deleted' database field equals 0)
     * Then simulates visiting the delete page for this product
     * Ensures the product is marked as deleted by checking the 'deleted' field in the database equals 1
     *
     * @return void
     */
    public function testDeleteProduct(): void
    {
        //Get Product 1 from Database
        $products = $this->getTableLocator()->get('products');
        $product = $products->get(1);

        //Assertion 1:
        //First check the product is not deleted - before deleted product page is visited
        $this->assertEquals(0, $product->deleted, 'Product should not be marked as deleted');

        //URL (Product Delete Route)
        $this->get('/product/delete/1/test-slug');

        //Assertion 2:
        //Check the page loads correctly / the response indicates success
        $this->assertResponseSuccess();

        //Get Product 1 from Database (refreshed - now the url has been visited)
        $products = $this->getTableLocator()->get('products');
        $product = $products->get(1);

        //Assertion 3:
        //Check the product is now deleted - as deleted product page has been visited
        $this->assertEquals(1, $product->deleted, 'Product should be marked as deleted');
    }

    /**
     * Test index method
     *
     * Simulates visiting the products page. Ensures the page loads correctly with a success response.
     * Checks the page contains certain text to ensure it loads in correct data.
     * 11-14 checks data for the specific products being added
     *
     * @return void
     */
    public function testIndex(): void
    {
        //URL (Products Index Page)
        $this->get('/products');

        //Assertion 1:
        //Check the page loads correctly / the response indicates success
        $this->assertResponseOk();

        //Assnertion 2-18: Check page cotains text
        $this->assertResponseContains('Products Page');
        $this->assertResponseContains('Add Product');
        $this->assertResponseContains('Search products...');
        $this->assertResponseContains('Filter by Status');
        $this->assertResponseContains('Update');
        $this->assertResponseContains('Name');
        $this->assertResponseContains('Quantity');
        $this->assertResponseContains('Price');
        $this->assertResponseContains('Status');
        $this->assertResponseContains('Last Updated');
        $this->assertResponseContains('Apple Juice');
        $this->assertResponseContains('50');
        $this->assertResponseContains('4.99');
        $this->assertResponseContains('In Stock');
        $this->assertResponseContains('Edit');
        $this->assertResponseContains('Delete');
        $this->assertResponseContains('Next');
    }

    /**
     * Test add new product with valid data
     *
     * Simulates submitting a form with valid product data.
     * Verifies that the product is successfully saved to the database.
     *
     * @return void
     */
    public function testAddNewProductValid(): void
    {
        //Form Data
        $data = [
            'name' => 'New Product',
            'quantity' => 50,
            'price' => 19.99,
        ];

        //Form Submit
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/product/add', $data);

        // Verify the product was saved
        $products = $this->getTableLocator()->get('products');
        $query = $products->find()->where(['name' => 'New Product']);
        $this->assertEquals(1, $query->count(), 'Product should be saved.');
    }

    /**
     * Test add new product with invalid data
     *
     * Simulates submitting a form with invalid product data.
     * Ensures the page contains certain error messages
     * Verifies that the product is does not successfully saved to the database.
     *
     * @return void
     */
    public function testAddNewProductInvalid(): void
    {
        //Form Data
        $data = [
            'name' => '', //Invalid: Name required
            'quantity' => -10, //Invalid: Quantitiy needs to be 0+
            'price' => 0, //Invalid: Price needs to be above 0
        ];

        //Form Submit
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/product/add', $data);

        //Assert validation errors are returned
        $this->assertResponseContains('Product name is required.');
        $this->assertResponseContains('Quantity cannot be negative.');
        $this->assertResponseContains('Price must be greater than zero.');

        // Verify the product was NOT saved
        $products = $this->getTableLocator()->get('products');
        $query = $products->find()->where(['name' => '']);
        $this->assertEquals(0, $query->count(), 'Product should not be saved.');
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\ProductsController::index()
     */
    /*public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test addEdit method
     *
     * @return void
     * @uses \App\Controller\ProductsController::addEdit()
     */
    /*public function testAddEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProductsController::delete()
     */
    /*public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    */
}
