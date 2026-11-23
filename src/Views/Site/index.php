<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<?php $posts = $posts ?? []; ?>
<?php $categories = $categories ?? []; ?>
<?php $featuredPosts = array_values(array_filter($posts, function ($post) {
    return ($post["name"] ?? "") === "Destaques";
})); ?>
<?php $galleryPosts = array_values(array_filter($posts, function ($post) {
    return ($post["name"] ?? "") === "Galeria";
})); ?>

<body>
    <?php require_once "components/header.php" ?>

    <!-- Main News Slider Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 px-0">
                <div class="owl-carousel main-carousel position-relative">
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        <img class="img-fluid h-100" src="<?= route("/src/assets/img/Benguela.jpg") ?>" alt="Autocarro da Trans Marques em viagem" style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">

                            </div>
                            <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="<?= route("/submission") ?>">
                            “O SEU DESTINO EM SEGURANÇA E COM QUALIDADE É A NOSSA MAIOR PRIORIDADE”.
                            </a>
                        </div>
                    </div>
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        <img class="img-fluid h-100" src="<?= route("/src/assets/img/dundo.jpg") ?>" alt="Paisagem do Dundo, Lunda Norte" style="object-fit: cover;">
                        <div class="overlay">
                            <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="<?= route("/submission") ?>">Uma viagem ao Dundo, Lunda Norte</a>
                        </div>
                    </div>
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        <img class="img-fluid h-100" src="<?= route("/src/assets/img/T5.jpg") ?>" alt="Viagem rodoviária em Angola" style="object-fit: cover;">
                        <div class="overlay">
                            <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="<?= route("/aboutus") ?>">Viaje com conforto e confiança</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 px-0">
                <div class="row mx-0">
                    <div class="col-md-6 px-0">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img class="img-fluid w-100 h-100" src="<?= route("/src/assets/img/T3.jpeg") ?>" alt="Equipa da Trans Marques" style="object-fit: cover;">
                            <div class="overlay">
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?= route("/aboutus") ?>">Tripulação</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 px-0">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img class="img-fluid w-100 h-100" src="<?= route("/src/assets/img/T1.png") ?>"
                                alt="Frota de autocarros"
                                style="object-fit: cover;">
                            <div class="overlay">
                                 <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?= route("/") ?>#galeria">Frota</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 px-0">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img class="img-fluid w-100 h-100" src="<?= route("/src/assets/img/T7.jpg") ?>"
                                alt="Autocarro preparado para viajar"
                                style="object-fit: cover;">
                            <div class="overlay">
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?= route("/") ?>#galeria">Agência de viagens</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 px-0">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img class="img-fluid w-100 h-100" src="<?= route("/src/assets/img/T6.jpg") ?>" alt="Trans Marques(8)" style="object-fit: cover;">
                            <div class="overlay">
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?= route("/aboutus") ?>">Trans Marques(8)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News Slider End -->

    <!-- Breaking News Start -->
    <div class="container-fluid bg-dark py-3 mb-3">
        <div class="container">
            <div class="row align-items-center bg-dark">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <strong class="bg-primary text-dark text-center font-weight-medium py-2 px-3 mb-2 mb-md-0">
                            Prepare a sua viagem
                        </strong>
                        <span class="text-white mx-md-3">Consulte os destinos e envie o seu pedido de agendamento online.</span>
                        <a class="text-primary font-weight-bold mt-2 mt-md-0" href="<?= route("/submission") ?>">
                            Fazer agendamento <i class="fa fa-arrow-right ml-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breaking News End -->

    <!-- Featured News Slider Start -->
    <div id="destaque" class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">Notícias em destaque</h4>
            </div>
        
                <?php if (empty($featuredPosts)) { ?>
                    <div class="alert alert-light border" role="status">
                        Ainda não há novidades em destaque. Volte em breve ou consulte as nossas
                        <a href="<?= route("/submission") ?>">opções de agendamento</a>.
                    </div>
                <?php } else { ?>
                <div class="owl-carousel news-carousel carousel-item-<?= min(count($featuredPosts), 4) ?> position-relative">
                    <?php foreach ($featuredPosts as $value) { ?>
                        <div class="position-relative overflow-hidden" style="height: 300px;">
                            <img class="img-fluid h-100" src="<?= htmlspecialchars(imageRepository($value['image']), ENT_QUOTES, "UTF-8") ?>"
                                alt="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                loading="lazy"
                                style="object-fit: cover;">
                            <div class="overlay">                               
                                <div class="mb-2">
                                    <span class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                        <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                    </span>
                                    <small class="text-white"><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></small>
                                </div>
                                <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold"
                                    href="<?= route("/details/" . (int)$value["id"]) ?>">
                                    <?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
        </div>
    </div>
    <!-- Featured News Slider End -->

    <!-- News With Sidebar Start -->
    <div id="galeria" class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Galeria</h4>
                            </div>
                        </div>

                        <?php if (empty($galleryPosts)) { ?>
                        <div class="col-12">
                            <p class="text-muted py-3">Ainda não há conteúdos publicados na galeria.</p>
                        </div>
                        <?php } ?>
                        <?php if (!empty($galleryPosts)) { ?>
                        <div class="col-12">
                          <div class="gallery-grid">
                        <?php foreach ($galleryPosts as $value) { ?>
                        <article class="gallery-card gallery-item">
                                <div class="gallery-media">
                                <?php if (isVideoMedia($value["image"] ?? null)) { ?>
                                <video controls preload="metadata" playsinline
                                    src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                    aria-label="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>">
                                    O seu navegador não suporta a reprodução deste vídeo.
                                </video>
                                <?php } else { ?>
                                <img src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                    alt="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                    loading="lazy">
                                <?php } ?>
                                </div>
                                <div class="gallery-card-body">
                                    <div class="mb-2">
                                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                            <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                        </span>
                                        <small class="text-body"><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></small>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold"
                                        href="<?= route("/details/" . (int)$value["id"]) ?>">
                                        <?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>
                                    </a>
                                    <p class="gallery-card-description m-0"><?= nl2br(htmlspecialchars($value["description"], ENT_QUOTES, "UTF-8")) ?></p>
                                </div>
                        </article>
                        <?php } ?>
                          </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>

                <div class="col-lg-12">
                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <?php if (empty($categories)) { ?>
                                    <span class="text-muted">Ainda não há categorias disponíveis.</span>
                                <?php } ?>
                                <?php foreach ($categories as $value) { ?>
                                <a href="<?= route("/categories/" . (int)$value["id"]) ?>"
                                    class="btn btn-sm btn-outline-secondary m-1">
                                    <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                </div>
            </div>
        </div>
        <!-- News With Sidebar End -->
        <!-- Travel Highlights Start -->
    <div class="tm-trust-strip">
      <div class="container">
        <div class="tm-trust-grid">
          <div class="tm-trust-item"><i class="fa fa-shield-alt"></i><div><strong>Viagem segura</strong><span>Compromisso com a segurança</span></div></div>
          <div class="tm-trust-item"><i class="fa fa-clock"></i><div><strong>Pontualidade</strong><span>Horários organizados</span></div></div>
          <div class="tm-trust-item"><i class="fa fa-road"></i><div><strong>Rotas interprovinciais</strong><span>Angola e região</span></div></div>
          <div class="tm-trust-item"><i class="fa fa-headset"></i><div><strong>Contacto directo</strong><span>Suporte durante a reserva</span></div></div>
        </div>
      </div>
    </div>

    <section class="tm-section">
      <div class="container">
        <div class="tm-section-heading">
          <h2>Viaje com conforto e confiança</h2>
          <p>Uma experiência organizada desde a reserva até ao destino final.</p>
        </div>
        <div class="tm-feature-grid">
          <article class="tm-feature-card"><i class="fa fa-shield-alt"></i><h5>Segurança primeiro</h5><p>Viagens planeadas com atenção aos passageiros e aos percursos.</p></article>
          <article class="tm-feature-card"><i class="fa fa-bus"></i><h5>Frota preparada</h5><p>Opções em veículos MAN e SCANIA para diferentes necessidades.</p></article>
          <article class="tm-feature-card"><i class="fa fa-calendar-check"></i><h5>Reserva simples</h5><p>Informe origem, destino e horário numa única solicitação.</p></article>
          <article class="tm-feature-card"><i class="fa fa-map-marker-alt"></i><h5>Principais destinos</h5><p>Conectamos várias províncias de Angola e destinos regionais.</p></article>
        </div>
      </div>
    </section>

    <section class="tm-section pt-0">
      <div class="container">
        <div class="tm-section-heading">
          <h2>Destinos populares</h2>
          <p>Consulte um destino ou faça já o seu agendamento.</p>
        </div>
        <div class="tm-destination-grid">
          <a class="tm-destination" href="<?= route("/submission") ?>?destination=Luanda"><img src="<?= route("/src/assets/img/Luanda.jpg") ?>" alt="Luanda"><strong>Luanda</strong></a>
          <a class="tm-destination" href="<?= route("/submission") ?>?destination=Benguela"><img src="<?= route("/src/assets/img/Benguela.jpg") ?>" alt="Benguela"><strong>Benguela</strong></a>
          <a class="tm-destination" href="<?= route("/submission") ?>?destination=Huambo"><img src="<?= route("/src/assets/img/Huambo.jpg") ?>" alt="Huambo"><strong>Huambo</strong></a>
          <a class="tm-destination" href="<?= route("/submission") ?>?destination=Saurimo"><img src="<?= route("/src/assets/img/Saurimo.jpg") ?>" alt="Saurimo"><strong>Saurimo</strong></a>
        </div>
      </div>
    </section>

    <section class="tm-section pt-0">
      <div class="container">
        <div class="tm-booking-cta">
          <div><h3>Pronto para viajar?</h3><p>Envie os detalhes da sua viagem e aguarde o contacto da equipa.</p></div>
          <a class="btn btn-primary px-4 py-3 font-weight-bold" href="<?= route("/submission") ?>">Fazer agendamento</a>
        </div>
      </div>
    </section>

    <section class="tm-section pt-0">
      <div class="container">
        <div class="tm-section-heading"><h2>Perguntas frequentes</h2><p>Informações úteis antes da sua viagem.</p></div>
        <div class="tm-faq">
          <details><summary>Como faço uma reserva?</summary><p>Preencha o formulário de Agendamento com origem, destino, data, hora e dados pessoais.</p></details>
          <details><summary>Posso reservar para várias pessoas?</summary><p>Sim. No formulário pode indicar o número de adultos e crianças que vão viajar.</p></details>
          <details><summary>Preciso confirmar a reserva?</summary><p>Após enviar o pedido, a equipa deverá confirmar disponibilidade e detalhes por telefone ou email.</p></details>
        </div>
      </div>
    </section>
    <!-- Travel Highlights End -->

    <?php require_once "components/footer.php" ?>
    <?php require_once "bottomBase.php" ?>
</body>

</html>