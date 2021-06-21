<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h2 class="d-flex">
              Venta N°: <?= $sale->id ?>
              <small class="ml-3">
                <?php if ($sale->status == 0): ?>
                  <span class="badge badge-danger">Cancelada</span>
                <?php else: ?>
                  <span class="badge badge-primary">Venta</span>
                <?php endif ?>
              </small>
            </h2>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12 col-sm-6">
        <div class="col-lg-6">
            Producto: <strong><?= $sale->p['name'] ?></strong>
        </div>
        <br>
        <div class="col-lg-6">
            Monto: <strong><?= $this->Number->currency($sale->amount) ?></strong>
        </div>
        <br>
        <div class="col-lg-6">
            Cantidad: <strong><?= $sale->quantity ?></strong>
        </div>
        <?php if($sale->discount > 0):?>
            <br>
            <div class="col-lg-6">
                Descuento: <strong><?= $sale->discount ?>% => </strong>
            </div>
            <br>
            <div class="col-lg-6">
                Monto del Descuento: <strong><?= $this->Number->currency($sale->discount_amount) ?></strong>
            </div>
        <?php endif; ?>
        <hr>
        <div class="col-lg-6">
            Marca: <strong><?= $sale->b['name'] ?></strong>
        </div>
        <br>
        <div class="col-lg-6">
            Categoría: <strong><?= $sale->c['name'] ?></strong>
        </div>
        <br>
        <div class="col-lg-6">
            Sucursal: <strong><?= $sale->br['name'] ?></strong>
        </div>
        <hr>
        <div class="col-lg-6">
            Vendido por: <strong><?= $sale->s['name'] . " " . $sale->s['surname'] ?></strong>
        </div>
        <br>
        <div class="col-lg-6">
            Venta realizada: <strong><?= $sale->saled_at->i18nFormat('dd/MM/yyyy | HH:mm') ?></strong>
        </div>
        <hr>
        <?php if ($sale->u['name'] !== null): ?>
        <div class="col-lg-6">
            Actualizado / Cancelado por: <strong><?= $sale->u['name'] . " " . $sale->u['surname'] ?></strong>
        </div>
        <br>
        <?php endif ?>
        <div class="col-lg-6">
            Venta actualizada/cancelada: <strong><?= $sale->updated_at->i18nFormat('dd/MM/yyyy | HH:mm') ?></strong>
        </div>
        <br>
        <?php if ($sale->reason_for_cancelling !== null): ?>
            <div class="col-lg-6">
                Razón de la anulación / cancelación: <strong><?= $sale->reason_for_cancelling ?></strong>
            </div>
            <br>
        <?php endif ?>
    </div>
</div>
