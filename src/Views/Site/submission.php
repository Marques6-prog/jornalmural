<!DOCTYPE HTML>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<?php
$travelLocations = \Vendor\Settings\TravelLocations::municipalitiesByProvince();
$selectedDestination = \Vendor\Settings\TravelLocations::findSelection($destination ?? "");
?>

<body>
<?php require_once "components/header.php" ?>

<main class="booking-page">
  <div class="booking-shell">
    <div class="booking-heading">
      <h1>Faça o seu agendamento</h1>
      <p>Planeie a sua viagem e receba contacto da nossa equipa.</p>
    </div>

    <div class="booking-card">
      <?php if (isset($_GET["status"]) && isset($_GET["msg"])) { ?>
        <div class="booking-alert <?= htmlspecialchars($_GET["status"]) ?>">
          <?= htmlspecialchars($_GET["msg"]) ?>
        </div>
      <?php } ?>

      <form action="<?= route("/booking/create") ?>" method="post">
        <h2 class="sub-heading-agileits">Detalhes da viagem</h2>
        <div class="booking-grid">
          <div class="booking-field">
            <label for="origin_province">Província de origem</label>
            <select id="origin_province" name="origin_province" required>
              <option value="">Selecione a província</option>
              <?php foreach ($travelLocations as $province => $municipalities) { ?>
                <option value="<?= htmlspecialchars($province, ENT_QUOTES, "UTF-8") ?>">
                  <?= htmlspecialchars($province, ENT_QUOTES, "UTF-8") ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="booking-field">
            <label for="origin">Município de origem</label>
            <select id="origin" name="origin" required disabled>
              <option value="">Selecione primeiro a província</option>
            </select>
          </div>
          <div class="booking-field">
            <label for="destination_province">Província de destino</label>
            <select id="destination_province" name="destination_province" required>
              <option value="">Selecione a província</option>
              <?php foreach ($travelLocations as $province => $municipalities) { ?>
                <option value="<?= htmlspecialchars($province, ENT_QUOTES, "UTF-8") ?>">
                  <?= htmlspecialchars($province, ENT_QUOTES, "UTF-8") ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="booking-field">
            <label for="destination">Município de destino</label>
            <select id="destination" name="destination" required disabled>
              <option value="">Selecione primeiro a província</option>
            </select>
          </div>

          <div class="booking-field">
            <label for="vehicle">Veículo preferido</label>
            <select id="vehicle" name="vehicle" required>
              <option value="">Selecione um veículo</option>
              <option>MAN</option><option>SCANIA</option>
            </select>
          </div>
          <div class="booking-field">
            <label for="seat_preference">Preferência de lugar</label>
            <select id="seat_preference" name="seat_preference">
              <option>Sem preferência</option><option>Janela</option><option>Corredor</option><option>Fundo</option>
            </select>
          </div>

          <div class="booking-field">
            <label for="departure_date">Data de partida</label>
            <input id="departure_date" type="date" name="departure_date" min="<?= date("Y-m-d") ?>" required>
          </div>
          <div class="booking-field">
            <label for="departure_time">Hora de partida</label>
            <input id="departure_time" type="time" name="departure_time" required>
          </div>

          <div class="booking-field full">
            <label>Tipo de viagem</label>
            <div class="trip-options">
              <div class="trip-option">
                <input type="radio" id="one_way" name="trip_type" value="one_way" checked>
                <label for="one_way">Só ida</label>
              </div>
              <div class="trip-option">
                <input type="radio" id="round_trip" name="trip_type" value="round_trip">
                <label for="round_trip">Ida e volta</label>
              </div>
            </div>
          </div>

          <div class="booking-field roundtrip-fields hidden">
            <label for="return_date">Data de regresso</label>
            <input id="return_date" type="date" name="return_date" min="<?= date("Y-m-d") ?>">
          </div>
          <div class="booking-field roundtrip-fields hidden">
            <label for="return_time">Hora de regresso</label>
            <input id="return_time" type="time" name="return_time">
          </div>

          <div class="booking-field">
            <label for="adults">Adultos</label>
            <select id="adults" name="adults">
              <option value="1">1 adulto</option><option value="2">2 adultos</option><option value="3">3 adultos</option>
              <option value="4">4 adultos</option><option value="5">5+ adultos</option>
            </select>
          </div>
          <div class="booking-field">
            <label for="children">Crianças</label>
            <select id="children" name="children">
              <option value="0">Nenhuma</option><option value="1">1 criança</option><option value="2">2 crianças</option>
              <option value="3">3 crianças</option><option value="4">4 crianças</option><option value="5">5+ crianças</option>
            </select>
          </div>
        </div>

        <h2 class="sub-heading-agileits3">Dados pessoais</h2>
        <div class="booking-grid">
          <div class="booking-field">
            <label for="full_name">Nome completo</label>
            <input id="full_name" type="text" name="full_name" placeholder="Nome completo" required minlength="3" maxlength="120" autocomplete="name">
          </div>
          <div class="booking-field">
            <label for="phone">Telefone</label>
            <input id="phone" type="tel" name="phone" placeholder="Ex: +244 900 000 000" required maxlength="50" autocomplete="tel" inputmode="tel">
          </div>
          <div class="booking-field full">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="nome@exemplo.com" required maxlength="120" autocomplete="email">
          </div>
          <div class="booking-field full">
            <label for="message">Mensagem opcional</label>
            <textarea id="message" name="message" placeholder="Informações adicionais sobre a viagem" maxlength="5000"></textarea>
          </div>
        </div>

        <h2 class="sub-heading-agileits4">Método de pagamento</h2>
        <div class="booking-field full payment-method-field">
          <label>Como pretende pagar?</label>
          <div class="payment-options">
            <div class="payment-option">
              <input type="radio" id="payment_transfer" name="payment_method" value="Transferência bancária" checked>
              <label for="payment_transfer"><i class="fa fa-university"></i><span>Transferência bancária</span></label>
            </div>
            <div class="payment-option">
              <input type="radio" id="payment_express" name="payment_method" value="Multicaixa Express">
              <label for="payment_express"><img class="payment-logo" src="<?= route("/src/assets/img/multicaixa-express.webp") ?>" alt="MULTICAIXA Express logo"><span>Multicaixa Express</span></label>
            </div>
            <div class="payment-option">
              <input type="radio" id="payment_cash" name="payment_method" value="Dinheiro no embarque">
              <label for="payment_cash"><i class="fas fa-money-bill-wave" aria-hidden="true"></i><span>Dinheiro no embarque</span></label>
            </div>
          </div>
          <p class="payment-note">O pagamento será confirmado pela nossa equipa após analisar a disponibilidade da viagem.</p>
        </div>

        <div class="booking-actions">
          <button type="reset" class="reset">Limpar formulário</button>
          <button type="submit" class="submit">Enviar agendamento</button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  const locationsByProvince = <?= json_encode($travelLocations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
  const selectedDestination = <?= json_encode($selectedDestination, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
  const originProvince = document.querySelector('#origin_province');
  const originMunicipality = document.querySelector('#origin');
  const destinationProvince = document.querySelector('#destination_province');
  const destinationMunicipality = document.querySelector('#destination');
  const departureDate = document.querySelector('#departure_date');
  const returnDate = document.querySelector('#return_date');

  const updateMunicipalities = (provinceSelect, municipalitySelect, selectedMunicipality = '') => {
    const municipalities = Object.entries(locationsByProvince[provinceSelect.value] || {});
    municipalitySelect.replaceChildren(new Option('Selecione um município', ''));
    municipalities.forEach(([value, label]) => municipalitySelect.add(new Option(label, value)));
    municipalitySelect.disabled = municipalities.length === 0;
    if (municipalities.some(([value]) => value === selectedMunicipality)) {
      municipalitySelect.value = selectedMunicipality;
    }
  };

  originProvince.addEventListener('change', () => updateMunicipalities(originProvince, originMunicipality));
  destinationProvince.addEventListener('change', () => updateMunicipalities(destinationProvince, destinationMunicipality));
  updateMunicipalities(originProvince, originMunicipality);
  if (selectedDestination) {
    destinationProvince.value = selectedDestination.province;
    updateMunicipalities(destinationProvince, destinationMunicipality, selectedDestination.municipality);
  } else {
    updateMunicipalities(destinationProvince, destinationMunicipality);
  }

  document.querySelectorAll('input[name="trip_type"]').forEach((radio) => {
    radio.addEventListener('change', () => {
      const roundTrip = document.querySelector('#round_trip').checked;
      document.querySelectorAll('.roundtrip-fields').forEach((field) => field.classList.toggle('hidden', !roundTrip));
      document.querySelector('#return_date').required = roundTrip;
      document.querySelector('#return_time').required = roundTrip;
      returnDate.min = departureDate.value || departureDate.min;
    });
  });

  departureDate.addEventListener('change', () => {
    returnDate.min = departureDate.value || departureDate.min;
    if (returnDate.value && returnDate.value < returnDate.min) {
      returnDate.value = '';
    }
  });
</script>

<?php require_once "components/footer.php" ?>

<?php require_once "bottomBase.php" ?>
</body>
</html>