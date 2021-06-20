<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create($sale) ?>
        <div class="form-group">
            <?= $this->Form->control('reason_for_cancelling', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Razón: (Requerido)',
                ],
                'required',
                'placeholder' => 'Razón de cancelación de compra / Devolución / Eliminar compra',
            ]) ?>
        </div>
        <div class="d-flex">
            <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => "btn btn-default text-danger"]) ?>
            <?= $this->Form->submit('Guardar', ['class' => "btn btn-danger"]) ?>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- /.panel-body -->
</div>