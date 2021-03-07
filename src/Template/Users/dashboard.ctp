<?php
    $this->assign('title', $title);
?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<hr>


<?= $this->Html->script('/js/dashboard.js', ['block' => 'scriptBottom']); ?>