<?php
    $this->assign('title', $title);
?>
<?= $this->Html->link(__('Nuevo Producto'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
<?= $this->Html->link(__('Actualizar Masivamente'), ['action' => 'bulkUpdate'], ['class' => 'button btn-info btn-sm float-right mr-4']) ?>
<?= $this->Html->link(__('Importar Masivamente'), ['action' => 'bulkImport'], ['class' => 'button btn-info btn-sm float-right mr-4']) ?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Kilos</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->kilos ?></td>
                    <td><?= $product->brand->name ?></td>
                    <td><?= $product->category->name ?></td>
                    <td class="actions">
                    <!-- <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $product->id],  ['class' => 'btn btn-sm btn-info']) ?> -->
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $product->id],  ['class' => 'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Eliminar',
                        ['action' => 'delete', $product->id],
                        [
                        'confirm' => __('Seguro que quieres eliminar {0}?', $product->name),
                        'class' => 'btn btn-sm btn-danger'
                        ]
                    ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
