<?php
    $this->assign('title', $title);
?>
<?= $this->Html->link(__('Actualizar Masivamente'), ['action' => 'bulkUpdate'], ['class' => 'button btn-primary btn-sm float-right']) ?>
<?= $this->Html->link(__('Descargar Plantilla para Actualizar Masivamente'), ['action' => 'downloadTemplate'], ['class' => 'button btn-primary btn-sm float-right mr-4']) ?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<!-- DataTales Example -->
<?php if($userProfileCode === 'ADMIN'): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <?= $this->Form->create(null) ?>
            <div class="col-lg-6">
            <?php if (isset($searchedBranch)): ?>
                <?= $this->Form->control('branch_id', [
                'options' => $branches,
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Sucursales: '
                ],
                'value' => $searchedBranch
                ]) ?>
            <?php else: ?>
                <?= $this->Form->control('branch_id', [
                'options' => $branches,
                'class' => 'form-control',
                'label' => [
                    'class' => 'control-label',
                    'text' => 'Sucursales: '
                ],
                ]) ?>
            <?php endif ?>
            </div>
            <br>
            <div class="col-lg-6">
            <button type="submit" id="submit" class="btn btn-primary">Buscar</button>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php endif; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <?php if($products !== null): ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio Unitario</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->brand ?></td>
                    <td><?= $product->category ?></td>
                    <td><?= $product->stock ?></td>
                    <td><?= $this->Number->currency($product->price) ?></td>
                    <td class="actions">
                    <?php if($product->sp_id != 0): ?>
                        <?php if($userProfileCode !== 'EMP'): ?>
                            <?= $this->Html->link(__('Ver Historial'), ['action' => 'view', $product->sp_id],  ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $product->sp_id],  ['class' => 'btn btn-sm btn-primary']) ?>
                        <?php endif; ?>
                    <?php else:?>
                        Tenes que actualizar la lista hacer el proceso una vez más
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <?php if($userProfileCode === 'ADMIN'): ?>
                <p>No has buscado el stock de la sucursal / No tiene un stock actual</p>
            <?php else:?>
                <p>Hay que inicializar el stock</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
