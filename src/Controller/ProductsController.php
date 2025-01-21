<?php

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ProductsController extends AppController
{
    /**
     * Index Method
     *
     * Displays a list of products with search and filters. Products are paginated
     *
     * @return null - Renders the view
     */
    public function index()
    {
        //Set Page Title
        $this->set('pageTitle', 'Products Page');

        //Form - Filters: Search
        $searchInput = $this->request->getQuery('search');

        //Form - Filters: Status
        $this->set('getProductStatusLabels', $this->Products->getProductStatusLabels());
        $statusesInput = $this->request->getQuery('statuses', []);
        $statusesInput = ($statusesInput == "" ? [] : $statusesInput);

        //Products Data
        $products = $this->Products->getProducts($searchInput, $statusesInput);

        //Pagination
        $this->paginate = [
            'limit' => 5, // Number of items per page
            'order' => [
                'Products.name' => 'asc', // Default sorting by name
            ],
        ];
        $products = $this->paginate($products);

        //Send Variables to View
        $this->set(compact('products', 'searchInput', 'statusesInput'));

        return null; //Return View in folder: Products/index
    }

    /**
     * Add/ Edit a Product
     *
     * @param int|null $productId - Id of the product to edit. null for adding new product
     * @return null - Renders the view or redirects on successful add/ edit of product
     * @throws NotFoundException if productId not found in the database
     */
    public function addEdit(?int $productId = null)
    {
        //Allow GET and POST
        $this->request->allowMethod(['get', 'post']);

        if ($productId) {
            //Check product with this ID exists
            $productExists = $this->Products->exists(['id' => $productId]);

            if ($productExists) {
                //Set $product to existing product (for editing)
                $product = $this->Products->get($productId) ?? [];

                //Set Page Title (Including Product Name)
                $this->set('pageTitle', 'Edit Product (' . $product->name . ')');
            } else {
                //Return error to user if Product with ID not found
                throw new NotFoundException(__('Product not found.'));
            }
        } else {
            //Set $product to blank product (for adding)
            $product = $this->Products->newEmptyEntity();

            //Set Page Title
            $this->set('pageTitle', 'Add Product');
        }

        if ($this->request->is('post')) {
            //Add or Edit Form Submission
            $product = $this->Products->patchEntity($product, $this->request->getData());

            if ($this->Products->save($product)) {
                //Product Saved - set success message & redirect to products index page
                $this->Flash->success('The product has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                //Product Errors - set error message(s) & stay on page
                $this->Flash->error('The product could not be saved. Please fix the errors below.');
            }
        }

        //Send Variables to View
        $this->set(compact('product'));

        return null; //Return View in folder: Products/add_edit
    }

    /**
     * Delete a Product
     *
     * @param int $productId - Id of the product to delete.
     * @return null - Redirects with success or error messages
     * @throws NotFoundException if productId not found in the database OR if not provided
     */
    public function delete(int $productId)
    {

        if ($productId) {
            //Check product with this ID exists
            $productExists = $this->Products->exists(['id' => $productId]);

            if ($productExists) {
                //Delete Product
                $productDeleted = $this->Products->deleteProduct($productId);

                if ($productDeleted) {
                    //Success Message
                    $this->Flash->success('The product has been marked as deleted.');
                } else {
                    //Error Message
                    $this->Flash->error('Failed to mark the product as deleted.');
                }

                //Return to home page with either the above success/ error message
                return $this->redirect(['action' => 'index']);
            } else {
                //Return error to user if Product with ID not found
                throw new NotFoundException(__('Product not found.'));
            }
        } else {
            //Return error to user if Product with ID not found
            throw new NotFoundException(__('No Product selected.'));
        }
    }
}
