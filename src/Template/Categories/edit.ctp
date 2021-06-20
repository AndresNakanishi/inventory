<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create($category) ?>
        <div class="form-group">
          <?= $this->Form->control('name', [
            'class' => 'form-control',
            'label' => [
              'class' => 'control-label',
              'text' => 'Nombre de la categoría: (Requerido)',
            ],
            'required',
            'placeholder' => 'Escribe el nombre de la categoría',
          ]) ?>
        </div>
        <div class="d-flex">
          <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => "btn btn-default text-danger"]) ?>
          <?= $this->Form->submit('Guardar', ['class' => "btn btn-primary"]) ?>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- /.panel-body -->
</div>