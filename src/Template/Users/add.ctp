<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create($user) ?>
        <div class="form-group">
            <?= $this->Form->control('profile_id', [
                'options' => $profiles,
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Tipo de membresía: (Requerido)',
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
                'placeholder' => 'Escribe el nombre del cliente',
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('surname', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Apellido: (Requerido)',
                ],
                'required',
                'placeholder' => 'Escribe el apellido del cliente',
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('dni', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'DNI: (Requerido)',
                ],
                'required',
                'placeholder' => 'Escribe el DNI del cliente',
                'max' => 11
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('address', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Dirección:',
                ],
                'placeholder' => 'Escribe la dirección del cliente',
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('email', [
                'class' => 'form-control',
                'type' => 'email',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'E-mail:',
                ],
                'placeholder' => 'Escribe el mail del cliente',
            ]) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('cellphone', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Celular:',
                ],
                'placeholder' => 'Escribe el celular del cliente',
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