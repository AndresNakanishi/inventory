<?php
    $this->assign('title', $title);
?>
<?= $this->Html->link(__('Agregar Perfil'), ['action' => 'add'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
                  <th>Código</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($profiles as $profile): ?>
            <tr>
              <td><?= $profile->name ?></td>
              <td><?= $profile->code ?></td>
              <td class="actions">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $profile->id],  ['class' => 'btn btn-sm btn-primary']) ?>
              </td>
            </tr>            
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
</div>