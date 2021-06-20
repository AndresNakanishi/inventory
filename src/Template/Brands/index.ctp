<?php
  $this->assign('title', $title);
?>
<?= $this->Html->link(__('Agregar marca'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
            <th>Marca</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($brands as $brand): ?>
          <tr>
            <td><?= $brand->id ?></td>
            <td><?= $brand->name ?></td>
            <td class="actions">
              <!-- <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $brand->id],  ['class' => 'btn btn-sm btn-info']) ?> -->
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $brand->id],  ['class' => 'btn btn-sm btn-primary']) ?>
              <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $brand->id], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Seguro que queres borrar {0}?', $brand->name)]) ?>
            </td>
          </tr>            
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
