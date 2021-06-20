<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
    <?= $this->Form->create($product) ?>
        <div class="form-group">
            <?= $this->Form->control('category_id', [
                'options' => $categories,
                'class' => 'form-control select-cucha',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Categoría: (Requerido)',
                ],
                'required'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('brand_id', [
                'options' => $brands,
                'class' => 'form-control select-cucha',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Marca: (Requerido)',
                ],
                'required'
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('name', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Nombre: (Requerido)',
                ],
                'required',
                'placeholder' => 'Escribe el nombre del producto',
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('kilos', [
                'class' => 'form-control',
                'step' => '.5',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Kilos: ',
                ],
                'placeholder' => 'Si tiene un peso, añadirlo',
            ]) ?>
        </div>
        <div class="d-flex">
            <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => "btn btn-default text-danger"]) ?>
            <?= $this->Form->submit('Añadir', ['class' => "btn btn-primary"]) ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- /.panel-body -->
</div>
