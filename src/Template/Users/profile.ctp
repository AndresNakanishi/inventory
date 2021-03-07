<?php
    $this->assign('title', $title);
?>
<?= $this->Html->link(__('Cambiar Contraseña'), ['action' => 'changePassword', $id], ['class' => 'button btn-primary btn-sm float-right']) ?>
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>