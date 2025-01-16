<?php 

namespace App\Controller;

class ProductsController extends AppController
{

    public function index()
    {
        $this->set('pageTitle', 'Products Page');

        //Form - Filters
            //Search    
            $searchInput = $this->request->getQuery('search');

            //Status
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

        $this->set(compact('products', 'searchInput', 'statusesInput'));

        //Return View in folder: Products/index
    }

    public function addEdit($productId = NULL, $productSlug = NULL)
    {
        $this->request->allowMethod(['get', 'post']); // Allow GET and POST

        if($productId) 
        {
            //Set Product to existing product (for editing)...
            $product = $this->Products->get($productId);

            $this->set('pageTitle', 'Edit Product ('.$product->name.')');
        }
        else
        {
            // ...set Product to new blank product (for adding)
            $product = $this->Products->newEmptyEntity();

            $this->set('pageTitle', 'Add Product');
        }

        if ($this->request->is('post')) 
        {
            //Add/ Edit Form Submission
            $product = $this->Products->patchEntity($product, $this->request->getData());

            if ($this->Products->save($product)) 
            {
                $this->Flash->success('The product has been saved.');
                return $this->redirect(['action' => 'index']);
            } 
            else 
            {
                $this->Flash->error('The product could not be saved. Please fix the errors below.');
            }
        }

        $this->set(compact('product'));
    }
    
    public function delete($productId, $productSlug = NULL)
    {

        $productDeleted = $this->Products->deleteProduct($productId);

        if($productDeleted) 
        {
            $this->Flash->success('The product has been marked as deleted.');
        }
        else
        {
            $this->Flash->error('Failed to mark the product as deleted.');
        }

        return $this->redirect(['action' => 'index']);
    }

}