<?php
    $title = "Sistema de Inventario | Login";
    $this->assign('title', $title);
?>
<!-- Outer Row -->
<div class="row justify-content-center align-items-center" style="height:100vh!important">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row" style="height:50vh!important">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Sistema de Inventario V1</h1>
                            </div>
                            <?= $this->Form->create() ?>
                                <div class="form-group">
                                    <?= $this->Form->control('dni', ['class' => 'form-control', 'label' => false, 'placeholder' => 'DNI']) ?>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->control('password', ['class' => 'form-control', 'type' => 'password', 'label' => false, 'placeholder' => 'Contraseña']) ?>
                                </div>
                                <?= $this->Form->submit('Login', ['class' => "btn btn-primary btn-user btn-block"]) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>