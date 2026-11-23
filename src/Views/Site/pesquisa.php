<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<?php $posts = $posts ?? []; ?>
<?php $search = is_string($search ?? null) ? trim($search) : ""; ?>

<body>
    <?php require_once "components/header.php" ?>

    <main class="container-fluid py-5">
        <div class="container">
            <section class="mb-3">
                    <div class="section-title mb-0">
                        <h1 class="h4 m-0 text-uppercase font-weight-bold">Resultados da pesquisa</h1>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <?php if ($search === "") { ?>
                            <p class="text-muted mb-0">Escreva um termo na pesquisa para encontrar publicações.</p>
                        <?php } elseif (empty($posts)) { ?>
                            <p class="text-muted mb-0">
                                Não foram encontradas publicações para
                                <strong>“<?= htmlspecialchars($search, ENT_QUOTES, "UTF-8") ?>”</strong>.
                                Experimente outro termo.
                            </p>
                        <?php } else { ?>
                            <p class="text-muted">Resultados para “<?= htmlspecialchars($search, ENT_QUOTES, "UTF-8") ?>”</p>
                            <?php foreach ($posts as $value) { ?>
                                <article class="bg-white mb-3 p-3 border rounded">
                                    <div class="mb-2">
                                        <span class="badge badge-primary"><?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?></span>
                                        <small class="text-muted ml-2"><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></small>
                                    </div>
                                    <h2 class="h5 mb-2">
                                        <a class="text-secondary text-uppercase font-weight-bold"
                                            href="<?= route("/details/" . (int)$value["id"]) ?>">
                                            <?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>
                                        </a>
                                    </h2>
                                    <p class="mb-0"><?= nl2br(htmlspecialchars($value["description"], ENT_QUOTES, "UTF-8")) ?></p>
                                </article>
                            <?php } ?>
                        <?php } ?>
                    </div>
            </section>
        </div>
    </main>
    <?php require_once "components/footer.php" ?>

    <!-- JavaScript Librarie+ -->
    <?php require_once "bottomBase.php" ?>
</body>

</html>