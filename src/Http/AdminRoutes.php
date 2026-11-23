<?php

use Slim\App;
use Vendor\Manager\View;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Domain\Category;

use Vendor\Controllers\User\{
  CreateUserController,
  AuthUserController,
  LogoutUserController
};

use Vendor\Controllers\Category\{
  CreateCategoryController,
  GetCategoriesController,
  GetCategoryByIdController,
  DeleteCategoryController,
  FindCategoryController,
  UpdateCategoryController
};

use Vendor\Controllers\Posts\{
  CreatePostController, 
  GetPostsController,
  FindPostController,
  DeletePostController,
  GetPotsByIdController,
  UpdatePostController,
  GetReciclePostsController,
  RecoverPostController
};

use Vendor\Repositories\VisitRepository;
use Vendor\Repositories\BookingRepository;
use Vendor\Repositories\NewsletterRepository;
use Vendor\Repositories\CategoryRepository;
use Vendor\Settings\GmailMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

return function (App $app) {
  $app->get("/backoffice", function () {
    Middleware::notAuthenticated();

    View::render("Admin", "index");
  });

  $app->get("/dashboard", function () {
    Middleware::authenticated();

    $postController = new GetPostsController();
    $totalPosts = $postController->handle();

    $visitRepository = new VisitRepository();

    View::render("Admin", "home", [
      "total" => count($totalPosts),
      "totalVisits" => $visitRepository->countUnique()
    ]);
  });

  $app->get("/backoffice/create", function () {
    Middleware::notAuthenticated();

    View::render("Admin", "account");
  });

  // Authentication
  $app->post("/admin/auth", [new AuthUserController, "handle"]);
  $app->get("/admin/logout", [new LogoutUserController, "handle"]);
  $app->post("/admin/create", [new CreateUserController, "handle"]);

  // Category
  $app->get("/create-category", function () {
    Middleware::authenticated();

    View::render("Admin", "create-category");
  });

  $app->post("/category/create", [new CreateCategoryController, "handle"]);

  $app->get("/list-category", function ($req) {
    Middleware::authenticated();

    $search = $req->getQueryParams()["search"] ?? "";

    $categories = [];

    $categoryController = new GetCategoriesController();
    $findController = new FindCategoryController(
      $search
    );

    if ($search !== "") {
      $categories["data"] = $findController->handle();
    } else {
      $categories["data"] = $categoryController->handle();
    }

    View::render("Admin", "list-category", [
      "categories" => $categories["data"],
      "search" => $search
    ]);
  });

  $app->post("/category/edit", [new UpdateCategoryController, "handle"]);
  $app->get("/category/{id}/edit", function ($req, $res, $args) {

    $getCategoty = new GetCategoryByIdController(
      intval($args["id"])
    );

    $currentCategory = $getCategoty->handle();

    View::render("Admin", "edit-category", [
      "id" => $currentCategory[0]["id"],
      "name" => $currentCategory[0]["name"]
    ]);
  });

  $app->get("/category/{id}/delete", function ($req, $res, $args) {
    Middleware::authenticated();

    $deleteCategoryController = new DeleteCategoryController(
      intval($args["id"])
    );

    $deleteCategoryController->handle();
  });

  // post
  $app->get("/create-post", function ($request) {
    Middleware::authenticated();

    $categoryController = new GetCategoriesController();
    $categories = $categoryController->handle();

    $query = $request->getQueryParams();
    $specialCategories = [
      "featured" => ["name" => "Destaques", "title" => "Adicionar notícia em destaque"],
      "gallery" => ["name" => "Galeria", "title" => "Adicionar foto ou vídeo à galeria"]
    ];
    $requestedCategoryId = $query["category_id"] ?? 0;
    $selectedCategoryId = is_scalar($requestedCategoryId) ? (int)$requestedCategoryId : 0;
    $createTitle = "Nova publicação";
    $kind = $query["kind"] ?? "";

    if (is_string($kind) && isset($specialCategories[$kind])) {
      $categoryRepository = new CategoryRepository();
      $categoryName = $specialCategories[$kind]["name"];
      $matchingCategories = $categoryRepository->getUserByName($categoryName);

      if (empty($matchingCategories)) {
        $categoryRepository->save(new Category($categoryName));
        $matchingCategories = $categoryRepository->getUserByName($categoryName);
        $categories = $categoryController->handle();
      }

      if (empty($matchingCategories)) {
        throw new RuntimeException("Unable to create the required post category.");
      }

      $selectedCategoryId = (int)$matchingCategories[0]["id"];
    }

    $selectedCategoryFound = false;
    $selectedCategoryName = "";
    foreach ($categories as $category) {
      if ((int)$category["id"] === $selectedCategoryId) {
        $selectedCategoryFound = true;
        $selectedCategoryName = $category["name"];
        $createTitle = $category["name"] === "Galeria"
          ? $specialCategories["gallery"]["title"]
          : ($category["name"] === "Destaques" ? $specialCategories["featured"]["title"] : "Nova publicação");
        break;
      }
    }
    if (!$selectedCategoryFound) {
      $selectedCategoryId = 0;
    }

    View::render("Admin", "create", [
      "categories" => $categories,
      "selectedCategoryId" => $selectedCategoryId,
      "createTitle" => $createTitle,
      "selectedCategoryName" => $selectedCategoryName
    ]);
  });
  
  $app->post("/create/post", [new CreatePostController, "handle"]);

  $app->get("/list-post", function ($req) {

    $search = $req->getQueryParams()["search"] ?? "";
    
    $postController = new GetPostsController();
    $findController = new FindPostController(
      $search
    );

    $posts = [];

    if ($search !== "") {
      $posts["data"] = $findController->handle();
    } else {
      $posts["data"] = $postController->handle();
    }

    View::render("Admin", "list", [
      "posts" => $posts["data"],
      "search" => $search
    ]);
  });
  
  $app->get("/post/{id}/update", function($req, $res, $args) {
    Middleware::authenticated();

    $findPostById = new GetPotsByIdController(
      intval($args["id"])
    );    
    $post = $findPostById->handle()[0];

    $categoryController = new GetCategoriesController();
    $categories = $categoryController->handle();

    View::render("Admin", "edit-post", [
      "id" => $post["id"],
      "title" => $post["title"],
      "description" => $post["description"],
      "categories" => $categories
    ]);
  });

  $app->post("/edit/post", [new UpdatePostController, "handle"]);

  $app->get("/post/{id}/delete", function($req, $res, $args) {
    Middleware::authenticated();

    $deletePostController = new DeletePostController(
      intval($args["id"])
    );

    $deletePostController->handle();
  });

  $app->get("/recicle", function() {

    $recyclePostsController = new GetReciclePostsController();

    View::render("Admin", "recicle", [
      "posts" => $recyclePostsController->handle()
    ]);
  });

  $app->get("/post/{id}/recover", function($req, $res, $args) {
    Middleware::authenticated();

    $recoverPostController = new RecoverPostController(intval($args["id"]));
    
    $recoverPostController->handle();
  });

  $app->get("/list-bookings", function () {
    Middleware::authenticated();

    $bookings = (new BookingRepository())->getAll();

    View::render("Admin", "list-bookings", [
      "bookings" => $bookings
    ]);
  });

  $app->post("/booking/status", function ($request) {
    Middleware::authenticated();

    $data = $request->getParsedBody();
    $allowed = ["nova", "contactada", "confirmada", "cancelada"];

    if (isset($data["id"], $data["status"]) && in_array($data["status"], $allowed, true)) {
      (new BookingRepository())->updateStatus((int)$data["id"], $data["status"]);
    }

    Application::redirect("/list-bookings");
  });

  $app->post("/booking/delete", function ($request) {
    Middleware::authenticated();

    $data = $request->getParsedBody();
    if (isset($data["id"])) {
      (new BookingRepository())->delete((int)$data["id"]);
    }

    Application::redirect("/list-bookings");
  });

  $app->post("/booking/delete-all", function () {
    Middleware::authenticated();

    (new BookingRepository())->deleteAll();
    Application::redirect("/list-bookings");
  });

  $app->get("/list-contacts", function () {
    Middleware::authenticated();

    $messages = (new \Vendor\Repositories\ContactRepository())->getAll();

    View::render("Admin", "list-contacts", [
      "messages" => $messages
    ]);
  });

  $app->post("/contact/delete", function ($request) {
    Middleware::authenticated();

    $data = $request->getParsedBody();
    if (isset($data["id"])) {
      (new \Vendor\Repositories\ContactRepository())->delete((int)$data["id"]);
    }

    Application::redirect("/list-contacts");
  });

  $app->post("/contact/delete-all", function () {
    Middleware::authenticated();

    (new \Vendor\Repositories\ContactRepository())->deleteAll();
    Application::redirect("/list-contacts");
  });

  $app->get("/newsletter", function ($request) {
    Middleware::authenticated();

    View::render("Admin", "newsletter", [
      "subscriberCount" => (new NewsletterRepository())->countActive(),
      "query" => $request->getQueryParams()
    ]);
  });

  $app->post("/newsletter/send", function ($request, $response) {
    Middleware::authenticated();

    $data = $request->getParsedBody() ?? [];
    $type = (string)($data["type"] ?? "");
    $title = trim((string)($data["title"] ?? ""));
    $message = trim((string)($data["message"] ?? ""));

    if (
      !in_array($type, ["route", "promotion"], true) ||
      $title === "" || strlen($title) > 150 ||
      $message === "" || strlen($message) > 5000
    ) {
      return $response->withRedirect(route("/newsletter") . "?status=invalid", 302);
    }

    $subscribers = (new NewsletterRepository())->getActiveSubscribers();
    if (count($subscribers) === 0) {
      return $response->withRedirect(route("/newsletter") . "?status=no-subscribers", 302);
    }

    try {
      $mailer = new GmailMailer();
    } catch (RuntimeException $exception) {
      error_log("Newsletter SMTP configuration error: " . $exception->getMessage());
      return $response->withRedirect(route("/newsletter") . "?status=config", 302);
    }

    $sent = 0;
    $failed = 0;
    $subject = str_replace(["\r", "\n"], "", $title);
    $kind = $type === "route" ? "Nova rota" : "Promoção";

    foreach ($subscribers as $subscriber) {
      $unsubscribeUrl = route("/newsletter/unsubscribe")
        . "?token=" . urlencode($subscriber["unsubscribe_token"]);
      $mailBody = "{$kind}: {$title}\n\n{$message}\n\n"
        . "Para cancelar a subscrição, aceda a: {$unsubscribeUrl}";

      try {
        $mailer->send($subscriber["email"], "[Trans Marques(8)] {$subject}", $mailBody);
        $sent++;
      } catch (PHPMailerException $exception) {
        error_log("Newsletter email delivery failed: " . $exception->getMessage());
        $failed++;
      }
    }

    return $response->withRedirect(
      route("/newsletter") . "?sent={$sent}&failed={$failed}",
      302
    );
  });
};
