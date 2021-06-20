<?php
  $this->assign('title', $title);
?>
<?= $this->Html->link(__('Ventas de Hoy'), ['action' => 'salesToday'], ['class' => 'button btn-primary btn-sm float-right ml-2']) ?>
<?= $this->Html->link(__('Vender'), ['action' => 'sale'], ['class' => 'button btn-primary btn-sm float-right']) ?>
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
            <th>#</th>
            <th>Día</th>
            <th>Producto</th>
            <th>Monto</th>
            <th>Estado</th>
            <?php if($userProfileCode === 'ADMIN'): ?>
            <th>Sucursal</th>
            <?php endif; ?>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sales as $sale): ?>
          <tr>
            <td><?= $sale->id ?></td>
            <td><?= $sale->saled_at->i18nFormat('dd/MM/yyyy') ?></td>
            <td><?= $sale->products['name'] ?></td>
            <td><?= $this->Number->currency($sale->amount) ?></td>
            <td><?= $sale->saleStatus ?></td>
            <?php if($userProfileCode === 'ADMIN'): ?>
            <td><?= $sale->branches['name'] ?></td>
            <?php endif; ?>
            <td class="actions">
              <?= $this->Html->link(__('Ver sus datos'), ['action' => 'view', $sale->id],  ['class' => 'btn btn-sm btn-info']) ?>
              <?php if($sale->status == 1): ?>
                <?= $this->Html->link(__('Cancelar'), ['action' => 'cancel', $sale->id],  ['class' => 'btn btn-sm btn-warning']) ?>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
