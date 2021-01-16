<!DOCTYPE html>
<html lang="es">
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
    <?= $this->Html->css('../vendor/datatables/dataTables.bootstrap4.min.css') ?>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?= $this->element('sidebar') ?>
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        
        <!-- Main Content -->
        <div id="content">
            <?= $this->element('topbar') ?>
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?= $this->fetch('content') ?>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        
        <?= $this->element('footer') ?>
      

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

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