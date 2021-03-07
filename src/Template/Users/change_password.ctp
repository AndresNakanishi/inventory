<?php
    $this->assign('title', $title);
?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create($user) ?>
        <div class="form-group">
          <?= $this->Form->control('old_password', [
            'class' => 'form-control',
            'type' => 'password',
            'label' => [
              'class' => 'control-label',
              'text' => 'Contraseña Actual:',
            ],
            'required',
            'placeholder' => 'Escribe tu contraseña actual',
          ]) ?>
        </div>
        <div class="form-group">
          <?= $this->Form->control('new_password', [
            'class' => 'form-control',
            'type' => 'password',
            'label' => [
              'class' => 'control-label',
              'text' => 'Contraseña Nueva:',
            ],
            'required',
            'placeholder' => 'Escribe tu contraseña nueva',
          ]) ?>
        </div>
        <div class="form-group">
          <?= $this->Form->control('new_password_confirm', [
            'class' => 'form-control',
            'type' => 'password',
            'label' => [
              'class' => 'control-label',
              'text' => 'Repetí Contraseña Nueva:',
            ],
            'required',
            'placeholder' => 'Repetí tu contraseña nueva',
          ]) ?>
        </div>
        <div class="d-flex">
            <?= $this->Html->link(__('Volver'), ['action' => 'profile', $id], ['class' => "btn btn-default text-primary"]) ?>
            <?= $this->Form->submit('Guardar', ['class' => "btn btn-primary"]) ?>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
  <!-- /.panel-body -->
</div>