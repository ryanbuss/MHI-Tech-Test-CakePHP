<div class="container">
    
    <h1>Products Page</h1>

    <a href="<?= $this->Url->build(['_name' => 'product.add']) ?>" class="btn btn-info">Add Product</a>

    <?php //Open Form (for search & filters) ?>
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index']]) ?>

        <br>

        <?php //Search Box ?>
        <?= $this->Form->control('search', [
            'label' => false,
            'placeholder' => 'Search products...',
            'value' => $this->request->getQuery('search'),
            'class' => 'form-control'
        ]) ?>

        <br>

        <?php //Statuses Checkboxes ?>
        <fieldset>
            <legend>Filter by Status</legend>
            <?= $this->Form->select('statuses', $getProductStatusLabels, [
                'multiple' => 'checkbox',
                'value' => $this->request->getQuery('statuses'),
                'class' => 'form-check-input'
            ]) ?>
        </fieldset>

        <br>

        <?php //Submit Button ?>
        <?= $this->Form->button('Update', [
            'class' => 'btn btn-success'
        ]) ?>

    <?= $this->Form->end() ?>

    <hr>

    <?php //Products Table ?>
    <?php if( ($products->count() ?? 0) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Last Updated</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= h($product->name) ?></td>
                        <td><?= h($product->quantity) ?></td>
                        <td>&pound;<?= h($product->price) ?></td>
                        <td><?= h($product->status) ?></td>
                        <td><?= ($product->updated != "" ? date('D jS M Y H:i', strtotime(h($product->updated))) : NULL) ?></td>
                        <td>
                            <a href="<?= $this->Url->build(['_name' => 'product.edit', 'productId' => $product->id, "productSlug" => $product->url_slug ?? 'product']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="" data-url="<?= $this->Url->build(['_name' => 'product.delete', 'productId' => $product->id, "productSlug" => $product->url_slug ?? 'product']); ?>" data-name="<?= h($product->name) ?>" class="btn btn-danger btn-sm delete-btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php //Pagination ?>
    <nav>
        <ul class="pagination">
            <?= $this->Paginator->first('<< First') ?>
            <?= $this->Paginator->prev('< Prev') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Next >') ?>
            <?= $this->Paginator->last('Last >>') ?>
        </ul>
    </nav>

</div>