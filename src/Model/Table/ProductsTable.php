<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('App\Model\Behavior\UpdateProductsTimestampBehavior');
    }

    //Get Products - with search filters
    public function getProducts(?String $search = null, Array $statuses = [])
    {
        $products = $this->find('all');

        //Filter Out Deleted
        $products->where(['deleted !=' => 1]);

        //Search
        if (!empty($search))
        {
            $products->where([
                'LOWER(Products.name) LIKE' => '%' . strtolower($search) . '%',
            ]);
        }

        //Filter based on status
        if (!empty($statuses)) 
        {
            $statusConditions = [];
            if (in_array(1, $statuses)) 
            {
                $statusConditions[] = ['Products.quantity >' => 10]; // In Stock
            }
            if (in_array(2, $statuses)) 
            {
                $statusConditions[] = ['Products.quantity BETWEEN 1 AND 10']; // Low Stock
            }
            if (in_array(3, $statuses)) 
            {
                $statusConditions[] = ['Products.quantity' => 0]; // No Stock
            }
            if (!empty($statusConditions)) 
            {
                $products->where(['OR' => $statusConditions]);
            }
        }

        $products->formatResults(function ($results) use ($statuses)
        {
            return $results->map(function ($product) use ($statuses)
            {
                /* ============
                    URL Slug 
                ============ */
                $slug = strtolower($product->name);
                
                // Replace non-alphanumeric characters with a hyphen
                $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
                
                // Trim hyphens from the beginning and end
                $slug = trim($slug, '-');
                
                $product->url_slug = $slug;
                

                /* ============
                    Statuses
                ============ */
                if($product->quantity > 10)
                {
                    $product->status_id = 1;
                }
                else if($product->quantity >= 1)
                {
                    $product->status_id = 2;
                }
                else
                {
                    $product->status_id = 3;
                }

                $product->status = $this->getProductStatusLabels()[$product->status_id ?? 0] ?? NULL;

                return $product;
            });
        });

        return $products;
    }

    //Get the product status labels
    public function getProductStatusLabels(): Array
    {
        return [
            1 => "In Stock",
            2 => "Low Stock",
            3 => "Out of Stock"
        ];
    }

    //Delete Product
    public function deleteProduct($productId)
    {
        $product = $this->get($productId);
        
        //Soft Delete - Update Database 'deleted' Column to 1
        $product->deleted = 1;

        if ($this->save($product)) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            //Validator for 'name' (Not Empty, At least 3 characters, no more than 50 characters, unique)
            ->requirePresence('name', 'create') // Make sure name if present on new entry
            ->notEmptyString('name', 'Product name is required.')
            ->minLength('name', 3, 'Product name must be at least 3 characters long.')
            ->maxLength('name', 50, 'Product name cannot exceed 50 characters.')
            ->add('name', 'unique', [
                'rule' => function ($value, $context)
                {
                    $conditions = ['name' => $value];

                    // Exclude the current record if editing
                    if (!empty($context['data']['id']))
                    {
                        $conditions['id !='] = $context['data']['id'];
                    }

                    // Check if unique
                    return !$this->exists($conditions);
                },
                'message' => 'The product name already exists'
            ]);

        $validator
            //Validator for 'quantity' (Integer, at least 0, no more than 1000, required)
            ->integer('quantity', 'Quantity must be an integer.')
            ->greaterThanOrEqual('quantity', 0, 'Quantity cannot be negative.')
            ->lessThanOrEqual('quantity', 1000, 'Quantity cannot exceed 1,000.')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity', 'Quantity is required.');

        $validator
            //Validator for 'price' (decimal (with 2 decimal spaces), at least 0, no more than 10000, required)
            ->decimal('price', 2, 'Price must be a valid decimal number.')
            ->greaterThan('price', 0, 'Price must be greater than zero.')
            ->lessThanOrEqual('price', 10000, 'Price cannot exceed 10,000.')
            ->requirePresence('price', 'create')
            ->notEmptyString('price', 'Price is required.');

        // Custom validation: Price > 100 requires quantity >= 10
        $validator->add('quantity', 'minQuantityForHighPrice', [
            'rule' => function ($value, $context) {
                if (!empty($context['data']['price']) && $context['data']['price'] > 100)
                {
                    return $value >= 10;
                }
                return true; // No price condition, allow
            },
            'message' => 'Products with a price greater than £100 must have a quantity of at least 10.'
        ]);

        // Custom validation: Name with "promo" requires price < 50
        $validator->add('price', 'promoPriceLimit', [
            'rule' => function ($value, $context) 
            {
                if (!empty($context['data']['name']) && stripos($context['data']['name'], 'promo') !== false) {
                    return $value < 50;
                }
                return true; // No "promo" in name, allow
            },
            'message' => 'Products with "promo" in the name must have a price less than £50.'
        ]);

        return $validator;
    }

}
