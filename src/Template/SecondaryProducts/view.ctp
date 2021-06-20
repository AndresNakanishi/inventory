<h1>
    <?= $secondaryProduct->product->name ?> - Stock Actual: <?= $secondaryProduct->stock ?> - Precio Actual: <?= $this->Number->currency($secondaryProduct->price) ?>
</h1>
<hr>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Fluctuaciones en el Precio</h6>
    </div>
    <div class="card-body">
        <?php if($inventoryLogPrices !== null): ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Valor Anterior</th>
                        <th>Delta</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryLogStock as $inv_log): ?>
                        <tr>
                            <td><?= $inv_log->id ?></td>
                            <td><?= $secondaryProduct->product->name ?></td>
                            <td><?= $inv_log->previous_value ?></td>
                            <td><?= $inv_log->delta ?></td>
                            <td><?= $inv_log->user->name." ".$inv_log->user->surname ?></td>
                            <td><span class="badge badge-primary"><?= $inv_log->action ?></span></td>
                            <td><?= $inv_log->changed_at->i18nFormat('dd/MM/yyyy | hh:mm') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aún no hubo movimientos de stock</p>
        <?php endif; ?>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Fluctuaciones en el Precio</h6>
    </div>
    <div class="card-body">
        <?php if($inventoryLogPrices !== null): ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Valor Anterior</th>
                        <th>Delta</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryLogPrices as $inv_log): ?>
                        <tr>
                            <td><?= $inv_log->id ?></td>
                            <td><?= $secondaryProduct->product->name ?></td>
                            <td><?= $inv_log->previous_value ?></td>
                            <td><?= $inv_log->delta ?></td>
                            <td><?= $inv_log->user->name." ".$inv_log->user->surname ?></td>
                            <td><span class="badge badge-primary"><?= $inv_log->action ?></span></td>
                            <td><?= $inv_log->changed_at->i18nFormat('dd/MM/yyyy | hh:mm') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aún no hubo movimientos de precio</p>
        <?php endif; ?>
    </div>
</div>
