<?php
  $this->assign('title', $title);
?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<div class="panel panel-default mb-5">
    <div class="panel-body">
        <div class="col-lg-6 col-sm-6">
            <?= $this->Form->create(null, ['type' => 'file']) ?>
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
                    <br>
                    <div class="form-group">
                        <label class="control-label" for="period">Archivo:</label>
                        <?=$this->Form->file(
                        'file',
                        [
                            'accept' => '.xls, .xlsx',
                            'required',
                            'class' => 'form-control-file',
                        ]
                        )?>
                    </div>
                </div>
                <br>
                <div class="col-lg-6">
                    <button type="submit" id="submit" class="btn btn-primary">Actualizar</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
