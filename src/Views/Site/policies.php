<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<body class="public-page-layout">
  <?php require_once "components/header.php" ?>

  <main class="public-hero-page">
    <div class="public-page-shell">
      <div class="public-page-heading">
        <h1>Políticas de reclamações e reembolso</h1>
        <p>Orientações para apresentar uma reclamação ou solicitar a análise de um reembolso.</p>
      </div>

      <div class="public-content-card">
        <section class="about-highlight">
          <h2 class="h4 text-uppercase font-weight-bold mb-3">Reclamações</h2>
          <p class="about-lead mb-0">
            Para apresentar uma reclamação, contacte a nossa equipa e descreva o sucedido.
            Inclua, sempre que possível, o nome associado ao agendamento, os dados da viagem
            e uma forma de contacto para podermos analisar o caso e responder.
          </p>
        </section>

        <section class="mt-4">
          <h2 class="h4 text-uppercase font-weight-bold mb-3">Pedidos de reembolso</h2>
          <p class="about-lead">
            Envie o pedido através da página de Contactos, indicando a referência do agendamento,
            o motivo do pedido e os dados de pagamento relevantes. A equipa analisará as
            informações e comunicará a decisão e os passos seguintes.
          </p>
          <p class="about-lead mb-0">
            A elegibilidade, o valor e a forma de eventual reembolso dependem das condições
            aplicáveis ao agendamento e da análise do caso. As condições específicas devem ser
            confirmadas com a equipa antes de concluir o pedido.
          </p>
        </section>

        <div class="mt-4">
          <a class="btn btn-primary px-4 py-3 font-weight-bold" href="<?= route("/contacts") ?>">Contactar a equipa</a>
        </div>
      </div>
    </div>
  </main>

  <?php require_once "components/footer.php" ?>
  <?php require_once "bottomBase.php" ?>
</body>
</html>
