<?php
    $title = 'GymAdminV1';
    $this->assign('title', $title);
?>
<div class="row">
    <div class="col-lg-12 d-flex flex-column align-items-center justify-content-center" style="height:100vh">
        <h1 style="color:#FFF!important;text-transform:uppercase">Sistema de Inventario (acá va la web)</h1>
        <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'button btn-success btn-sm']) ?>
    </div>
</div>