<?php
  $this->assign('title', $title);
?>
<?= $this->Html->link(__('Nuevo Cliente'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
            <th>Nombre</th>
            <th>DNI</th>
            <th>Dirección</th>
            <th>Celular</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
          <tr>
            <td><?= $user->name ." ". $user->surname ?></td>
            <td><?= h($user->dni) ?></td>
            <td><?= h($user->address) ?></td>
            <td><?= h($user->cellphone) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $user->id],  ['class' => 'btn btn-sm btn-primary']) ?>
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id],  ['class' => 'btn btn-sm btn-primary']) ?>
            </td>
          </tr>            
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>