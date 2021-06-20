<?php
  $this->assign('title', $title);
?>
<?= $this->Html->link(__('Agregar sucursal'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
            <th>Ubicación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($branches as $branch): ?>
          <tr>
            <td><?= $branch->id ?></td>
            <td><?= $branch->name ?></td>
            <td><?= $branch->location ?></td>
            <td class="actions">
              <!-- <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $branch->id],  ['class' => 'btn btn-sm btn-info']) ?> -->
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $branch->id],  ['class' => 'btn btn-sm btn-primary']) ?>
              <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $branch->id], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Seguro que queres borrar {0}?', $branch->name)]) ?>  
            </td>
          </tr>            
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
