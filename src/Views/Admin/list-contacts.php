<!DOCTYPE html>
<html lang="pt-pt">
<?php include_once "topBase.php" ?>
<?php $messages = $messages ?? []; ?>
<body>
  <div class="container-scroller">
    <?php include_once "components/header.php" ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once "components/sidebar.php" ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="bo-page-head">
            <div><h1>Mensagens de contacto</h1><p>Mensagens enviadas através do formulário de Contactos.</p></div>
            <?php if (!empty($messages)) { ?>
              <form method="post" action="<?= route("/contact/delete-all") ?>" onsubmit="return confirm('Apagar todas as mensagens? Esta ação não pode ser desfeita.')">
                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-sweep me-1"></i>Apagar todas</button>
              </form>
            <?php } ?>
          </div>
          <div class="card"><div class="card-body">
            <h4 class="card-title">Caixa de entrada</h4>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead><tr><th>Remetente</th><th>Assunto</th><th>Mensagem</th><th>Recebida em</th><th>Entrega</th><th>Ações</th></tr></thead>
                <tbody>
                  <?php if (empty($messages)) { ?><tr><td colspan="6" class="text-center text-muted py-5">Ainda não existem mensagens.</td></tr><?php } ?>
                  <?php foreach ($messages as $message) { ?>
                    <tr>
                      <td><strong><?= htmlspecialchars($message["full_name"]) ?></strong><br><a href="mailto:<?= htmlspecialchars($message["email"]) ?>"><?= htmlspecialchars($message["email"]) ?></a></td>
                      <td><?= htmlspecialchars($message["subject"]) ?></td>
                      <td><?= nl2br(htmlspecialchars($message["message"])) ?></td>
                      <td><?= htmlspecialchars($message["created_at"]) ?></td>
                      <td><span class="badge <?= $message["email_sent"] ? "badge-success" : "badge-warning" ?>"><?= $message["email_sent"] ? "Email enviado" : "Guardada no sistema" ?></span></td>
                      <td>
                        <form method="post" action="<?= route("/contact/delete") ?>" onsubmit="return confirm('Tem a certeza que deseja apagar esta mensagem?')">
                          <input type="hidden" name="id" value="<?= $message["id"] ?>">
                          <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete me-1"></i>Apagar</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div></div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once "bottomBase.php" ?>
</body>
</html>
