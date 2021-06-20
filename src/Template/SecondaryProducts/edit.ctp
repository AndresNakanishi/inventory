<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
    <div class="panel-body">
        <div class="col-lg-6 col-sm-6">
            <?= $this->Form->create($secondaryProduct) ?>
            <div class="form-group">
                <?= $this->Form->control('profile_id', [
                'options' => $products,
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Producto:',
                ],
                'disabled'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('stock', [
                    'class' => 'form-control',
                    'label' => [
                        'class' => 'control-label',
                        'text' => 'Stock Actual:',
                    ],
                    'required',
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('price', [
                    'class' => 'form-control',
                    'label' => [
                        'class' => 'control-label',
                        'text' => 'Precio Unitario:',
                    ],
                    'required',
                ]) ?>
            </div>
            <div class="d-flex">
                <?= $this->Html->link(__('Volver'), ['controller' => 'SecondaryProducts', 'action' => 'index'], ['class' => "btn btn-default text-primary"]) ?>
                <?= $this->Form->submit('Guardar', ['class' => "btn btn-primary"]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
<!-- /.panel-body -->
</div>
