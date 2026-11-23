<!DOCTYPE html>
<html lang="pt-pt">

<?php include_once "topBase.php"; ?>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-md-8 col-lg-5 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo"><i class="mdi mdi-newspaper-variant-outline me-2"></i>Trans Marques(8)</div>
              <h4 class="mb-1 font-weight-bold">Bem-vindo de volta</h4>
              <h6 class="font-weight-light text-muted mb-4">Entre para gerir o conteúdo da plataforma.</h6>

              <?php if (isset($_GET["status"]) && isset($_GET["msg"])) { ?>
                <div class="alert alert-<?= htmlspecialchars($_GET["status"]) ?>">
                  <?= htmlspecialchars($_GET["msg"]) ?>
                </div>
              <?php } ?>

              <form method="post" action="<?= route("/admin/auth") ?>" class="pt-2">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control form-control-lg" placeholder="nome@exemplo.com" required />
                </div>
                <div class="form-group">
                  <label>Palavra-passe</label>
                  <div class="password-wrap">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required />
                  </div>
                </div>
                <button type="submit" class="w-100 btn btn-primary btn-lg mt-2">Entrar no painel</button>
                <div class="text-center mt-4 text-muted">
                  Ainda não tem uma conta?
                  <a href="<?= route("/backoffice/create") ?>" class="text-primary font-weight-bold">Criar conta</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once "bottomBase.php" ?>
</body>

</html>