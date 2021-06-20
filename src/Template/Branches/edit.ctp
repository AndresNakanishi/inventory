<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create($branch) ?>
      <div class="form-group">
          <?= $this->Form->control('name', [
            'class' => 'form-control',
            'label' => [
              'class' => 'control-label',
              'text' => 'Nombre de la sucursal: (Requerido)',
            ],
            'required',
            'placeholder' => 'Escribe el nombre de la sucursal',
          ]) ?>
        </div>
        <div class="form-group">
          <?= $this->Form->control('location', [
            'class' => 'form-control',
            'label' => [
              'class' => 'control-label',
              'text' => 'Ubicación: (Requerido)',
            ],
            'required',
            'placeholder' => 'Escribe el nombre del lugar',
          ]) ?>
        </div>
        <div class="d-flex">
          <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => "btn btn-default text-primary"]) ?>
          <?= $this->Form->submit('Guardar', ['class' => "btn btn-primary"]) ?>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- /.panel-body -->
</div>