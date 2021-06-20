<?php
$this->assign('title', $title);
?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<div class="panel panel-default mb-5">
    <div class="panel-body">
        <div class="col-lg-6 col-sm-6">
            <?= $this->Form->create(null) ?>
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
                <br>
                <div class="col-lg-6">
                    <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => "btn btn-default text-primary"]) ?>
                    <button type="submit" id="submit" class="btn btn-primary">Descargar</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
