<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<?php $posts = $posts ?? []; ?>
<?php $comments = $comments ?? []; ?>

<body>
    <?php require_once "components/header.php" ?>


    <!-- Breaking News Start -->
    <div class="container-fluid mt-5 mb-3 pt-3">
        <div class="container"></div>
    </div>
    <!-- Breaking News End -->

    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- News Detail Start -->
                    <?php if (empty($posts)) { ?>
                        <div class="alert alert-warning" role="status">
                            Esta publicação não está disponível. <a href="<?= route("/") ?>">Voltar ao início</a>.
                        </div>
                    <?php } ?>
                    <?php foreach ($posts as $value) { ?>
                        <div class="position-relative mb-3">
                            <?php if (isVideoMedia($value["image"] ?? null)) { ?>
                            <video class="img-fluid w-100" controls preload="metadata" playsinline
                                src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                aria-label="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                style="aspect-ratio: 16 / 9; object-fit: cover; background: #000;">
                                O seu navegador não suporta a reprodução deste vídeo.
                            </video>
                            <?php } else { ?>
                            <img class="img-fluid w-100"
                                src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                alt="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                style="object-fit: cover;" />
                            <?php } ?>

                            <div class="bg-white border border-top-0 p-4">
                                <div class="mb-3">
                                    <span class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                        <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                    </span>
                                    <small class="text-body"><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></small>
                                </div>
                                <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?></h1>
                                <p><?= nl2br(htmlspecialchars($value["description"], ENT_QUOTES, "UTF-8")) ?></p>

                            </div>
                            <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                <div class="d-flex align-items-center">
                                    <span class="ml-3"><i class="fa fa-comment mr-2" aria-hidden="true"></i><?= count($comments) ?> comentários</span>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <!-- News Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Comentários</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">

                        <?php 
                            foreach ($comments as $value) {
                        ?>
                            <div class="media mb-4">                                
                                <div class="media-body">
                                    <h6>
                                        <strong class="text-secondary"><?= htmlspecialchars($value["username"], ENT_QUOTES, "UTF-8") ?></strong>
                                        <small><i><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></i></small>
                                    </h6>
                                    <p>
                                        <?= nl2br(htmlspecialchars($value["description"], ENT_QUOTES, "UTF-8")) ?>
                                    </p>                                    
                                </div>
                            </div>   
                        <?php } ?>                       
                        <?php if (empty($comments)) { ?>
                            <p class="text-muted mb-0">Ainda não há comentários. Seja o primeiro a comentar.</p>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Deixe um comentário</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">

                            <?php
                                if (isset($_GET["status"]) && isset($_GET["msg"])) {
                                ?>
                                <div class="alert alert-<?= htmlspecialchars($_GET["status"], ENT_QUOTES, "UTF-8") ?>">
                                    <span><?= htmlspecialchars($_GET["msg"], ENT_QUOTES, "UTF-8") ?></span>
                                </div>
                            <?php } ?>

                            <?php if (!empty($posts)) { ?>
                            <form
                                method="post"
                                action="<?= route("/post/comment") ?>"
                            >
                                <input type="hidden" name="id" value="<?= (int)$posts[0]["id"] ?>">
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nome *</label>
                                            <input 
                                                type="text" class="form-control" 
                                                id="name"
                                                name="username"
                                                required
                                                maxlength="80"
                                                autocomplete="name"
                                                >
                                        </div>
                                    </div>                                  
                                </div>
                              
                                <div class="form-group">
                                    <label for="message">Mensagem *</label>
                                    <textarea id="message" cols="30" rows="5" name="description" class="form-control"
                                        required maxlength="2000"></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Deixe um comentario" class="btn btn-primary font-weight-semi-bold py-2 px-3">
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Comment Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->

    <?php require_once "components/footer.php" ?>

    <!-- JavaScript Libraries -->
    <?php require_once "bottomBase.php" ?>
</body>

</html>