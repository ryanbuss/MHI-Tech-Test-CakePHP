<div class="container">
    
    <h1><?= (isset($product) && $product->id ? "Edit" : "Add") ?> Product</h1>
    <?php if(!empty($product->name ?? "")): ?>
        <h2>Product: <?= h($product->name); ?></h2>
    <?php endif; ?>

    <?php //Open Form ?>
    <?= $this->Form->create($product, ['type' => 'post']) ?>

        <br>

        <?= $this->Form->control('name', [
            'label' => "Product Name",
            'required' => true,
            'placeholder' => 'Enter product name...',
            'value' => $this->request->getQuery('name') ?? $product->name ?? null,
            'class' => 'form-control'
        ]) ?>

        <br>

        <?= $this->Form->control('quantity', [
            'label' => "Product Quantity",
            'type' => 'number',
            'placeholder' => 'Enter product quantity...',
            'value' => $this->request->getQuery('quantity') ?? $product->quantity ?? null,
            'class' => 'form-control'
        ]) ?>

        <br>

        <?= $this->Form->control('price', [
            'label' => "Product Price (£)",
            'type' => 'number',
            'step' => '0.01',
            'min' => '0',
            'placeholder' => 'Enter product price...',
            'value' => $this->request->getQuery('price') ?? $product->price ?? null,
            'class' => 'form-control'
        ]) ?>

        <br>

        <?php //Submit Button ?>
        <?= $this->Form->button('Save', [
            'class' => 'btn btn-success'
        ]) ?>

    <?= $this->Form->end() ?>

</div>