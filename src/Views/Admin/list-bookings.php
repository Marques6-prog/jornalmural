<!DOCTYPE html>
<html lang="pt-pt">
<?php include_once "topBase.php"; ?>
<?php $bookings = $bookings ?? []; ?>
<body>
  <div class="container-scroller">
    <?php include_once "components/header.php"; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once "components/sidebar.php"; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="bo-page-head">
            <div>
              <h1>Agendamentos</h1>
              <p>Pedidos recebidos através do formulário de viagem.</p>
            </div>
            <?php if (!empty($bookings)) { ?>
              <form method="post" action="<?= route("/booking/delete-all") ?>" onsubmit="return confirm('Apagar todos os agendamentos? Esta ação não pode ser desfeita.')">
                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-sweep me-1"></i>Apagar todos</button>
              </form>
            <?php } ?>
          </div>

          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Lista de reservas</h4>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Cliente</th>
                      <th>Rota</th>
                      <th>Partida</th>
                      <th>Passageiros</th>
                      <th>Contacto</th>
                      <th>Pagamento</th>
                      <th>Estado</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($bookings)) { ?>
                      <tr><td colspan="8" class="text-center text-muted py-5">Ainda não existem agendamentos.</td></tr>
                    <?php } ?>
                    <?php foreach ($bookings as $booking) { ?>
                      <tr>
                        <td>
                          <strong><?= htmlspecialchars($booking["full_name"]) ?></strong><br>
                          <small class="text-muted">#<?= (int)$booking["id"] ?> · <?= htmlspecialchars($booking["created_at"]) ?></small>
                        </td>
                        <td><?= htmlspecialchars($booking["origin"]) ?> <i class="mdi mdi-arrow-right"></i> <?= htmlspecialchars($booking["destination"]) ?></td>
                        <td><?= htmlspecialchars($booking["departure_date"]) ?><br><small><?= htmlspecialchars($booking["departure_time"]) ?></small></td>
                        <td><?= (int)$booking["adults"] ?> adultos · <?= (int)$booking["children"] ?> crianças</td>
                        <td>
                          <a href="tel:<?= htmlspecialchars($booking["phone"]) ?>"><?= htmlspecialchars($booking["phone"]) ?></a><br>
                          <a href="mailto:<?= htmlspecialchars($booking["email"]) ?>"><?= htmlspecialchars($booking["email"]) ?></a>
                        </td>
                        <td><?= htmlspecialchars($booking["payment_method"] ?? "Dinheiro no embarque") ?></td>
                        <td>
                          <form method="post" action="<?= route("/booking/status") ?>">
                            <input type="hidden" name="id" value="<?= (int)$booking["id"] ?>">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                              <?php foreach (["nova" => "Nova", "contactada" => "Contactada", "confirmada" => "Confirmada", "cancelada" => "Cancelada"] as $value => $label) { ?>
                                <option value="<?= $value ?>" <?= $booking["status"] === $value ? "selected" : "" ?>><?= $label ?></option>
                              <?php } ?>
                            </select>
                          </form>
                        </td>
                        <td>
                          <form method="post" action="<?= route("/booking/delete") ?>" onsubmit="return confirm('Apagar este agendamento?')">
                            <input type="hidden" name="id" value="<?= (int)$booking["id"] ?>">
                            <button type="submit" class="bo-action delete"><i class="mdi mdi-delete-outline me-1"></i>Apagar</button>
                          </form>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once "bottomBase.php" ?>
</body>
</html>
