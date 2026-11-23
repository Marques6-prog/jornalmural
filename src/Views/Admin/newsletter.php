<!DOCTYPE html>
<html lang="pt-pt">
<?php include_once "topBase.php"; ?>
<body>
  <div class="container-scroller">
    <?php include_once "components/header.php"; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once "components/sidebar.php"; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="bo-page-head">
            <div>
              <h1>Newsletter</h1>
              <p>Envie novidades sobre novas rotas e promoções aos subscritores.</p>
            </div>
          </div>

          <?php if (isset($query["status"]) && $query["status"] === "invalid") { ?>
            <div class="alert alert-danger" role="alert">Preencha todos os campos corretamente.</div>
          <?php } ?>
          <?php if (isset($query["status"]) && $query["status"] === "config") { ?>
            <div class="alert alert-danger" role="alert">
              O envio por Gmail ainda não está configurado. Defina
              <code>NEWSLETTER_GMAIL_ADDRESS</code> e
              <code>NEWSLETTER_GMAIL_APP_PASSWORD</code> no ambiente do Apache e reinicie o serviço.
            </div>
          <?php } ?>
          <?php if (isset($query["status"]) && $query["status"] === "no-subscribers") { ?>
            <div class="alert alert-warning" role="alert">Ainda não há subscritores ativos para receber a newsletter.</div>
          <?php } ?>
          <?php if (isset($query["sent"]) || isset($query["failed"])) { ?>
            <div class="alert alert-info" role="status">
              Emails enviados: <?= max(0, (int)($query["sent"] ?? 0)) ?>.
              Falhas: <?= max(0, (int)($query["failed"] ?? 0)) ?>.
            </div>
          <?php } ?>

          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Enviar anúncio</h4>
              <p class="card-description">
                <?= (int)$subscriberCount ?> subscritor(es) ativo(s).
                As mensagens incluem uma ligação para cancelar a subscrição.
              </p>
              <form method="post" action="<?= route("/newsletter/send") ?>" class="forms-sample">
                <div class="form-group">
                  <label for="newsletter-type">Tipo de novidade</label>
                  <select id="newsletter-type" name="type" class="form-control" required>
                    <option value="route">Nova rota</option>
                    <option value="promotion">Promoção</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="newsletter-title">Título</label>
                  <input id="newsletter-title" name="title" type="text" class="form-control"
                    maxlength="150" required>
                </div>
                <div class="form-group">
                  <label for="newsletter-message">Detalhes</label>
                  <textarea id="newsletter-message" name="message" class="form-control"
                    rows="6" maxlength="5000" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                  <?= $subscriberCount === 0 ? "disabled" : "" ?>>
                  Enviar para subscritores
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once "bottomBase.php"; ?>
</body>
</html>
