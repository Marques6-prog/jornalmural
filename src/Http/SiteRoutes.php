<?php

use Slim\App;
use Vendor\Manager\View;
use Vendor\Repositories\VisitRepository;
use Vendor\Repositories\BookingRepository;
use Vendor\Repositories\ContactRepository;
use Vendor\Repositories\NewsletterRepository;
use Vendor\Settings\GmailMailer;
use Vendor\Settings\TravelLocations;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

use Vendor\Controllers\Posts\GetPostsController;
use Vendor\Controllers\Posts\FilterPostController;
use Vendor\Controllers\Posts\GetPotsByIdController;
use Vendor\Controllers\Category\GetCategoriesController;
use Vendor\Controllers\User\ShowCategoryDetailsController;

use Vendor\Controllers\Comments\AddCommentIntoPostController;
use Vendor\System\Usecases\Comments\GetCommentsByPostUseCase;

return function (App $app) {
    $app->get("/", function () {

        $visitorKey = $_COOKIE["jornalmural_visitor"] ?? "";

        if ($visitorKey === "") {
            $visitorKey = hash("sha256", bin2hex(random_bytes(16)));
            setcookie("jornalmural_visitor", $visitorKey, [
                "expires" => time() + (365 * 24 * 60 * 60),
                "path" => "/",
                "samesite" => "Lax"
            ]);
        }

        (new VisitRepository())->record($visitorKey);

        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();

        $getPostController = new GetPostsController();
        $posts = $getPostController->handle();

        View::render("Site", "index", [
            "search" => "",
            "categories" => $categories,
            "posts" => $posts
        ]);
    });

    $app->get("/details/{id}", function ($req, $resp, $args) {

        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();

        $getPosts = new GetPotsByIdController(intval($args["id"]));

        $commentsUseCase = new GetCommentsByPostUseCase();
        $comments = $commentsUseCase->execute(intval($args["id"]));
        
        View::render("Site", "single", [
            "search" => "",
            "posts" => $getPosts->handle(),
            "categories" => $categories,
            "comments" => $comments
        ]);
    });

    $app->get("/categories/{id}", [new ShowCategoryDetailsController, "handle"]);

    $app->get("/contacts", function ($req, $resp, $args) {

        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();

        View::render("Site", "contact", [
            "search" => "",
            "categories" => $categories,
        ]);
    });

    $app->get("/politicas-reclamacoes-reembolso", function () {
        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();

        View::render("Site", "policies", [
            "search" => "",
            "categories" => $categories,
        ]);
    });

    $app->get("/aboutus", function ($req, $resp, $args) {
        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();

        View::render("Site", "about_us", [
            "search" => "",
            "categories" => $categories,
        ]);
    });

    $app->get("/search", [new FilterPostController, "handle"]);

    $app->post("/post/comment", [new AddCommentIntoPostController, "handle"]);

    $app->get("/submission", function ($request) {
        $getCategoryController = new GetCategoriesController();
        $categories = $getCategoryController->handle();
        View::render("Site", "submission",[
            "search" => "",
            "categories" => $categories,
            "destination" => (string)($request->getQueryParams()["destination"] ?? ""),
        ]);
    });

    $app->post("/booking/create", function ($request, $response) {
        $data = $request->getParsedBody() ?? [];

        $required = ["origin_province", "origin", "destination_province", "destination", "vehicle", "departure_date", "departure_time", "trip_type", "full_name", "phone", "email", "payment_method"];
        foreach ($required as $field) {
            if (empty(trim((string)($data[$field] ?? "")))) {
                return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Preencha todos os campos obrigatórios."), 302);
            }
        }

        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Informe um email válido."), 302);
        }

        $originProvince = trim((string)$data["origin_province"]);
        $originMunicipality = trim((string)$data["origin"]);
        $destinationProvince = trim((string)$data["destination_province"]);
        $destinationMunicipality = trim((string)$data["destination"]);
        if (
            !TravelLocations::isValidSelection($originProvince, $originMunicipality) ||
            !TravelLocations::isValidSelection($destinationProvince, $destinationMunicipality)
        ) {
            return $response->withRedirect(
                route("/submission") . "?status=danger&msg=" . urlencode("Selecione uma origem e um destino diferentes e válidos."),
                302
            );
        }

        $origin = TravelLocations::formatLocation($originProvince, $originMunicipality);
        $destination = TravelLocations::formatLocation($destinationProvince, $destinationMunicipality);
        if ($origin === $destination) {
            return $response->withRedirect(
                route("/submission") . "?status=danger&msg=" . urlencode("Selecione uma origem e um destino diferentes e válidos."),
                302
            );
        }

        $tripType = (string)$data["trip_type"];
        if (!in_array($tripType, ["one_way", "round_trip"], true)) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Selecione um tipo de viagem válido."), 302);
        }

        $departureDateValue = trim((string)$data["departure_date"]);
        $departureDate = \DateTimeImmutable::createFromFormat("!Y-m-d", $departureDateValue);
        $departureTime = trim((string)$data["departure_time"]);
        if (
            !$departureDate ||
            $departureDate->format("Y-m-d") !== $departureDateValue ||
            $departureDate < new \DateTimeImmutable("today") ||
            preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $departureTime) !== 1
        ) {
            return $response->withRedirect(
                route("/submission") . "?status=danger&msg=" . urlencode("Informe uma data e hora de partida válidas."),
                302
            );
        }

        $returnDateValue = null;
        $returnTime = null;
        if ($tripType === "round_trip") {
            $returnDateValue = trim((string)($data["return_date"] ?? ""));
            $returnDate = \DateTimeImmutable::createFromFormat("!Y-m-d", $returnDateValue);
            $returnTime = trim((string)($data["return_time"] ?? ""));
            if (
                !$returnDate ||
                $returnDate->format("Y-m-d") !== $returnDateValue ||
                $returnDate < $departureDate ||
                preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $returnTime) !== 1 ||
                ($returnDate == $departureDate && $returnTime <= $departureTime)
            ) {
                return $response->withRedirect(
                    route("/submission") . "?status=danger&msg=" . urlencode("A data e a hora de regresso devem ser posteriores à partida."),
                    302
                );
            }
        }

        $vehicle = trim((string)$data["vehicle"]);
        if (!in_array($vehicle, ["MAN", "SCANIA"], true)) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Selecione um veículo válido."), 302);
        }

        $seatPreference = trim((string)($data["seat_preference"] ?? "Sem preferência"));
        if (!in_array($seatPreference, ["Sem preferência", "Janela", "Corredor", "Fundo"], true)) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Selecione uma preferência de lugar válida."), 302);
        }

        $adults = filter_var($data["adults"] ?? 1, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]]);
        $children = filter_var($data["children"] ?? 0, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 5]]);
        if ($adults === false || $children === false) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Indique um número válido de passageiros."), 302);
        }

        $fullName = trim((string)$data["full_name"]);
        $phone = trim((string)$data["phone"]);
        $email = trim((string)$data["email"]);
        $message = trim((string)($data["message"] ?? ""));
        if (
            strlen($fullName) > 120 ||
            strlen($phone) > 50 ||
            strlen($email) > 120 ||
            strlen($message) > 5000 ||
            preg_match('/^[0-9+().\s-]{7,50}$/', $phone) !== 1 ||
            strlen(preg_replace('/\D/', '', $phone)) < 7
        ) {
            return $response->withRedirect(
                route("/submission") . "?status=danger&msg=" . urlencode("Verifique os seus dados pessoais e tente novamente."),
                302
            );
        }

        $allowedPaymentMethods = ["Transferência bancária", "Multicaixa Express", "Dinheiro no embarque"];
        $paymentMethod = trim($data["payment_method"] ?? "");
        if (!in_array($paymentMethod, $allowedPaymentMethods, true)) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Selecione um método de pagamento válido."), 302);
        }

        $booking = [
            "origin" => $origin,
            "destination" => $destination,
            "vehicle" => $vehicle,
            "seat_preference" => $seatPreference,
            "departure_date" => $departureDateValue,
            "departure_time" => $departureTime,
            "return_date" => $returnDateValue,
            "return_time" => $returnTime,
            "trip_type" => $tripType,
            "adults" => $adults,
            "children" => $children,
            "full_name" => $fullName,
            "phone" => $phone,
            "email" => $email,
            "payment_method" => $paymentMethod,
            "message" => $message
        ];

        $saved = (new BookingRepository())->create($booking);

        if (!$saved) {
            return $response->withRedirect(route("/submission") . "?status=danger&msg=" . urlencode("Não foi possível enviar o agendamento. Tente novamente."), 302);
        }

        return $response->withRedirect(route("/submission") . "?status=success&msg=" . urlencode("Agendamento enviado com sucesso! Entraremos em contacto."), 302);
    });

    $app->post("/contact/send", function ($request, $response) {
        $data = $request->getParsedBody();
        $name = trim((string)($data["name"] ?? ""));
        $email = trim((string)($data["email"] ?? ""));
        $subject = trim((string)($data["subject"] ?? ""));
        $message = trim((string)($data["message"] ?? ""));

        if ($name === "" || $email === "" || $subject === "" || $message === "") {
            return $response->withRedirect(route("/contacts") . "?status=danger&msg=" . urlencode("Preencha todos os campos."), 302);
        }

        if (
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($name) > 120 ||
            strlen($email) > 120 ||
            strlen($subject) > 180 ||
            strlen($message) > 5000
        ) {
            return $response->withRedirect(route("/contacts") . "?status=danger&msg=" . urlencode("Verifique o email e o tamanho dos campos."), 302);
        }

        $mailBody = "Nome: {$name}\nEmail: {$email}\n\nMensagem:\n{$message}";
        $emailSent = false;
        try {
            (new GmailMailer())->send(
                "transmarques23@hotmail.com",
                "[Site] " . str_replace(["\r", "\n"], "", $subject),
                $mailBody,
                $email
            );
            $emailSent = true;
        } catch (\RuntimeException $exception) {
            error_log("Contact email configuration error: " . $exception->getMessage());
        } catch (PHPMailerException $exception) {
            error_log("Contact email delivery failed: " . $exception->getMessage());
        }

        (new ContactRepository())->create([
            "full_name" => $name,
            "email" => $email,
            "subject" => $subject,
            "message" => $message,
            "email_sent" => $emailSent ? 1 : 0
        ]);

        $statusMessage = $emailSent
            ? "Mensagem enviada com sucesso!"
            : "Mensagem guardada. O servidor de email não respondeu, mas a equipa poderá consultá-la no backoffice.";

        return $response->withRedirect(
            route("/contacts") . "?status=" . ($emailSent ? "success" : "danger") . "&msg=" . urlencode($statusMessage),
            302
        );
    });

    $app->post("/newsletter/subscribe", function ($request, $response) {
        $data = $request->getParsedBody() ?? [];
        $email = trim((string)($data["email"] ?? ""));

        if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $response->withRedirect(route("/") . "?newsletter=invalid", 302);
        }

        $saved = (new NewsletterRepository())->subscribe($email);

        return $response->withRedirect(
            route("/") . "?newsletter=" . ($saved ? "success" : "error"),
            302
        );
    });

    $app->get("/newsletter/unsubscribe", function ($request, $response) {
        $token = (string)($request->getQueryParams()["token"] ?? "");

        if (preg_match('/^[a-f0-9]{64}$/', $token) === 1) {
            (new NewsletterRepository())->unsubscribe($token);
        }

        return $response->withRedirect(route("/") . "?newsletter=unsubscribed", 302);
    });
};
