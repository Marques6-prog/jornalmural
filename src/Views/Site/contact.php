<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php"?>
<body>
<?php require_once "components/header.php" ?>

<main class="public-hero-page">
  <div class="public-page-shell">
    <div class="public-page-heading">
      <h1>Contactos</h1>
      <p>Estamos disponíveis para responder às suas perguntas e pedidos.</p>
    </div>

    <div class="public-content-card">
      <?php if (isset($_GET["status"]) && isset($_GET["msg"])) { ?>
        <div class="contact-alert <?= htmlspecialchars($_GET["status"]) ?>">
          <?= htmlspecialchars($_GET["msg"]) ?>
        </div>
      <?php } ?>

      <div class="contact-layout">
        <aside class="contact-info">
          <h6 class="text-uppercase font-weight-bold mb-2">Informação de contacto</h6>
          <div class="contact-info-item">
            <i class="far fa-envelope-open"></i>
            <div><h6>Email</h6><a href="mailto:transmarques23@hotmail.com">transmarques23@hotmail.com</a></div>
          </div>
          <div class="contact-info-item">
            <i class="fa fa-phone-alt"></i>
            <div><h6>Telefone</h6><a href="tel:+244937645564">+244 937 645 564</a></div>
          </div>
        </aside>

        <section class="contact-form-card">
          <h6 class="text-uppercase font-weight-bold mb-3">Envie-nos uma mensagem</h6>
          <form action="<?= route("/contact/send") ?>" method="post">
            <div class="contact-fields">
              <div class="contact-field">
                <label for="contact-name">Seu nome</label>
                <input id="contact-name" type="text" name="name" placeholder="Nome completo" required minlength="3" maxlength="120" autocomplete="name">
              </div>
              <div class="contact-field">
                <label for="contact-email">Seu email</label>
                <input id="contact-email" type="email" name="email" placeholder="nome@exemplo.com" required maxlength="120" autocomplete="email">
              </div>
              <div class="contact-field full">
                <label for="contact-subject">Assunto</label>
                <input id="contact-subject" type="text" name="subject" placeholder="Assunto da mensagem" required maxlength="180">
              </div>
              <div class="contact-field full">
                <label for="contact-message">Mensagem</label>
                <textarea id="contact-message" name="message" placeholder="Escreva a sua mensagem" required minlength="10" maxlength="5000"></textarea>
              </div>
            </div>
            <button class="contact-submit" type="submit">Envie uma mensagem</button>
          </form>
        </section>
      </div>
    </div>
  </div>
</main>

<?php require_once "components/footer.php" ?>
<?php require_once "bottomBase.php" ?>
</body>
</html>