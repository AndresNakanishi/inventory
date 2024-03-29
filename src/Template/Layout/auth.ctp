<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon', 'favicon.png', ['type'=>'image/png']) ?>

    <!-- Custom fonts for this template-->
    <?= $this->Html->css('../vendor/fontawesome-free/css/all.min.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <?= $this->Html->css('sb-admin-2.min.css') ?>

</head>

<body class="bg-gradient-primary">

  <div class="container">
        <?= $this->fetch('content') ?>
  </div>

  <!-- Bootstrap core JavaScript-->
  <!-- Bootstrap core JavaScript-->
  <?= $this->Html->script('/vendor/jquery/jquery.min.js'); ?>
  <?= $this->Html->script('/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>

  <!-- Core plugin JavaScript-->
  <?= $this->Html->script('/vendor/jquery-easing/jquery.easing.min.js'); ?>
  <?= $this->Html->script('/vendor/notify/notify.js'); ?>

  <!-- Custom scripts for all pages-->
  <?= $this->Html->script('/js/sb-admin-2.min.js'); ?>

  <!-- Page level plugins -->
  <?= $this->Html->script('/vendor/datatables/jquery.dataTables.min.js'); ?>
  <?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js'); ?>

  <!-- Page level custom scripts -->
  <?= $this->Html->script('/js/demo/datatables-demo.js'); ?>
  <?= $this->fetch('scriptBottom') ?>
  <?= $this->Flash->render() ?>

</body>

</html>
