<?php
  $this->assign('title', $title);
?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-6 col-md-2">
        <img src="<?= $user->avatar ?>" alt="<?= $user->name." ".$user->surname; ?>" class="img-rounded img-responsive" />
      </div>
      <div class="col-sm-6 col-md-10">
        <h4><?= $user->name." ".$user->surname; ?></h4>
        <hr>
        <p>
          <b>DNI:</b>
          <?= $user->dni ?>
        </p>
        <p>
          <b>Email:</b>
          <?= $user->email ?>
        </p>
        <p>
          <b>Celular:</b>
          <?= $user->cellphone ?>
        </p>
      </div>
    </div>
  </div>
</div>