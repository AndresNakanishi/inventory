<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>

<div class="panel panel-default mb-5">
    <div class="panel-body">
        <div class="col-lg-8 col-sm-8">
            <?= $this->Form->create($sale) ?>
                <?php if(isset($branches) && $userProfileCode === 'ADMIN'): ?>
                    <div class="form-group">
                    <?= $this->Form->control('branch_id', [
                            'options' => $branches,
                            'class' => 'form-control',
                            'label' => [
                                'class' => 'control-label',
                                'text' => 'Sucursal: (Requerido)',
                            ],
                            'id' => 'branches',
                        ]) ?>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <?= $this->Form->control('payment_method_id', [
                        'options' => $paymentMethods,
                        'class' => 'form-control',
                        'label' => [
                            'class' => 'control-label',
                            'text' => 'Método de pago: (Requerido)',
                        ],
                        'required'
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('product_id', [
                        'options' => $products,
                        'class' => 'form-control select-cucha',
                        'label' => [
                            'class' => 'control-label',
                            'text' => 'Producto: (Requerido)',
                        ],
                        'id' => 'products',
                        'required'
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('quantity', [
                        'class' => 'form-control',
                        'step' => '.05',
                        'label' => [
                            'class' => 'control-label',
                            'text' => 'Cantidad: (Requerido)',
                        ],
                        'placeholder' => 'Escribe la cantidad si no es alimento suelto',
                        'required'
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('discount', [
                        'class' => 'form-control',
                        'label' => [
                            'class' => 'control-label',
                            'text' => 'Descuento: (Por defecto 0)',
                        ],
                        'value' => 0,
                        'placeholder' => 'Escribe el descuento si aplica',
                        'max' => 100,
                        'maxlength' => 3,
                        'onchange' => "changeHandler(this)"
                    ]) ?>
                </div>
                <div class="d-flex">
                    <?= $this->Html->link(__('Volver'), $redirect, ['class' => "btn btn-default text-danger"]) ?>
                    <?= $this->Form->submit('Vender', ['class' => "btn btn-primary"]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
<script>
    function changeHandler(val)
    {
        if (Number(val.value) > 100)
        {
            val.value = 100
        }
    }
</script>
