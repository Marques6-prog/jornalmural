<!DOCTYPE html>
<html>

<?php include_once "topBase.php"; ?>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">Trans Marques(8)</div>
              <h4>Olá! vamos começar a postar</h4>
              <h6 class="font-weight-light mb-3">Crie a sua conta agora.</h6>

              <?php
              if (isset($_GET["status"]) && isset($_GET["msg"])) {
              ?>
                <div class="alert alert-<?= $_GET["status"] ?>">
                  <span> <?= $_GET["msg"] ?> </span>
                </div>
              <?php } ?>

              <form class="pt-2" method="post" action="<?= route("/admin/create") ?>" enctype="multipart/form-data">

                <div class="form-group">
                  <input type="text" name="name" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Name" maxlength="80" minlength="3" />
                  <div class="invalid-feedback">Digite um nome válido.</div>
                </div>

                <div class="form-group">
                  <input type="text" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" />
                </div>

                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" />
                  <small class="text-small text-gray mt-2" style="font-size: 11px; max-width: 90%; display: block; line-height: 14px;">
                    No mínimo 8 caracteres, pelo menos uma letra maiúscula, uma
                    letra minúscula, um número e um caractere especial ex:
                    @$!%*?&.
                  </small>
                </div>

                <div class="form-group">
                  <input type="password" name="confirmPass" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Confirm password" />
                  <small class="text-small text-gray mt-2" style="font-size: 11px; max-width: 90%; display: block; line-height: 14px;">
                    A password precisa ser similar a de cima
                  </small>
                </div>

                <div class="form-group">
                  <input type="file" name="photo" accept=".jpg, .png, .jpeg" class="form-control" />
                </div>

                <div class="mt-3">
                  <button type="submit" class="w-100 btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    Criar conta
                  </button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Já tenho uma conta?
                  <a href="<?= route("/backoffice") ?>" class="text-primary">Entrar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <?php include_once "bottomBase.php" ?>
</body>

</html>