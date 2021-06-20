<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<div class="panel panel-default mb-5">
  <div class="panel-body">
    <div class="col-lg-6 col-sm-6">
      <?= $this->Form->create(null) ?>
        <?php if($userProfileCode === 'ADMIN'): ?>
          <?php if(isset($branches)): ?>
            <div class="col-lg-6">
              <?= $this->Form->control('branch_id', [
                'options' => $branches,
                'class' => 'form-control',
                'label' => [
                  'class' => 'control-label',
                  'text' => 'Sucursales: '
                ],
                'required',
                ]) ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <div class="col-lg-6">
          <?= $this->Form->control(
            'date',
            [
              'class' => 'form-control date',
              'id'=> 'date',
              'label' => [
                'class' => 'control-label',
                'text' => 'Mes: '
              ],
              'type' => 'text',
              'autocomplete' => 'off',
              'div' => false,
              'placeholder' => 'MM  /  AAAA',
              'required'
            ])
          ?>
        </div>
        <br>
        <div class="col-lg-6">
          <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
        </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<?= $this->Html->script("/js/datepicker-admin.js", ['block' => 'scriptBottom']);?>
