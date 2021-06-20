<?php
  $this->assign('title', $title);
?>
<?= $this->Html->link(__('Nuevo Usuario'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
            <th>Nombre Completo</th>
            <th>Dirección</th>
            <th>Celular</th>
            <th>Estado</th>
            <th>Perfil</th>
            <th>Sucursal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
          <tr>
            <td><?= $user->fullName ?></td>
            <td><?= h($user->address) ?></td>
            <td><?= h($user->cellphone) ?></td>
            <td><?= $user->userState ?></td>
            <td> <span class="badge badge-primary"> <?= $user->profile->name ?> </span></td>
            <td> <span class="badge badge-primary"> <?= (isset($user->branch->name)) ? $user->branch->name : 'Administrador' ?> </span></td>
            <td class="actions">
              <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $user->id],  ['class' => 'btn btn-sm btn-info']) ?>
              <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id],  ['class' => 'btn btn-sm btn-primary']) ?>
              <?php if ($user->active == 0): ?>
                  <?= $this->Form->postLink(
                      'Habilitar', 
                      ['action' => 'delete', $user->id], 
                      [
                        'confirm' => __('Seguro que quieres habilitar a {0}?', $user->name),
                        'class' => 'btn btn-sm btn-danger'
                      ]
                  ) ?>
              <?php else: ?>
                  <?= $this->Form->postLink(
                      'Deshabilitar', 
                      ['action' => 'delete', $user->id], 
                      [
                        'confirm' => __('Seguro que quieres deshabilitar a {0}?', $user->name),
                        'class' => 'btn btn-sm btn-danger'
                      ]
                  ) ?>
              <?php endif ?>
            </td>
          </tr>            
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>