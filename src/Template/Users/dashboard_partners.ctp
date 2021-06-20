<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total (Diario)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->Number->currency($allTotalDay) ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<br>
<div class="row">
  <div class="col-lg-12">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ingresos Diarios</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Día</th>
                <th>Total</th>
                <th>Cantidad de Ventas</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($allDays as $day): ?>
                <tr>
                  <td><?= $day->date ?></td>
                  <td><?= $this->Number->currency($day->total) ?></td>
                  <td><?= $day->sales_amount ?></td>
                </tr>            
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>