<!-- Footer Start -->
  <footer class="tm-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <h5>Trans Marques(8)</h5>
          <p class="mt-3">Viagens interprovinciais organizadas com segurança, conforto e compromisso com o passageiro.</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5>Links rápidos</h5>
          <div class="tm-footer-links mt-3">
            <a href="<?= route("/") ?>">Início</a>
            <a href="<?= route("/aboutus") ?>">Quem Somos</a>
            <a href="<?= route("/submission") ?>">Agendamento</a>
            <a href="<?= route("/contacts") ?>">Contactos</a>
            <a href="<?= route("/politicas-reclamacoes-reembolso") ?>">Políticas de reclamações e reembolso</a>
          </div>
        </div>
        <div class="col-lg-5 col-md-12 mb-4">
          <h5>Contactos</h5>
          <div class="tm-footer-links mt-3">
            <a href="tel:+244937645564"><i class="fa fa-phone-alt mr-2 text-primary"></i>+244 937 645 564</a>
            <a href="mailto:transmarques23@hotmail.com"><i class="far fa-envelope mr-2 text-primary"></i>transmarques23@hotmail.com</a>
            <span><i class="fa fa-map-marker-alt mr-2 text-primary"></i>Angola</span>
            <div class="tm-footer-social" aria-label="Redes sociais">
              <a href="https://web.facebook.com/p/Trans-Marques-100093028507356/" target="_blank" rel="noopener noreferrer"
                aria-label="Trans Marques no Facebook" title="Facebook">
                <i class="fab fa-facebook-f" aria-hidden="true"></i>
              </a>
              <a href="https://wa.me/244937645564" target="_blank" rel="noopener noreferrer"
                aria-label="Falar com a Trans Marques no WhatsApp" title="WhatsApp">
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="tm-footer-newsletter">
        <div>
          <h5>Receba novidades</h5>
          <p>Subscreva para receber novidades sobre novas rotas e promoções.</p>
        </div>
        <div class="tm-footer-newsletter-form">
          <?php
            $newsletterMessages = [
              "success" => ["success", "Email inscrito com sucesso!"],
              "invalid" => ["danger", "Informe um email válido."],
              "error" => ["danger", "Não foi possível concluir a inscrição. Tente novamente."],
              "unsubscribed" => ["success", "A sua inscrição foi cancelada."]
            ];
            $newsletterStatus = $_GET["newsletter"] ?? "";
          ?>
          <?php if (isset($newsletterMessages[$newsletterStatus])) { ?>
            <p class="tm-newsletter-feedback <?= $newsletterMessages[$newsletterStatus][0] ?>" role="status">
              <?= htmlspecialchars($newsletterMessages[$newsletterStatus][1], ENT_QUOTES, "UTF-8") ?>
            </p>
          <?php } ?>
          <form method="post" action="<?= route("/newsletter/subscribe") ?>" class="tm-newsletter-form">
            <label class="sr-only" for="newsletter-email">O seu email</label>
            <input id="newsletter-email" name="email" type="email" maxlength="254" required
              placeholder="O seu endereço de email" autocomplete="email">
            <button type="submit" class="btn btn-primary">Subscrever</button>
          </form>
          <small>Pode cancelar a subscrição a qualquer momento.</small>
        </div>
      </div>
      <div class="tm-footer-bottom">
        &copy; <?= date("Y") ?> Trans Marques(8). Todos os direitos reservados. |
        <strong>Developed by
          <a href="https://marques6-prog.github.io/" target="_blank" rel="noopener noreferrer">JexDev</a>
        </strong>
      </div>
    </div>
  </footer>
  <!-- Footer End -->

  <!-- Back to Top -->
  <a href="#" class="btn btn-primary btn-square back-to-top" aria-label="Voltar ao topo">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
  </a>