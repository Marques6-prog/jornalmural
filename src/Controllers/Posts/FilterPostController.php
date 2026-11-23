<?php

namespace Vendor\Controllers\Posts;

use Vendor\Manager\View;
use Vendor\System\Usecases\Post\FindPostsUseCase;
use Vendor\Controllers\Category\GetCategoriesController;

class FilterPostController
{
    private string $search = "";
    private FindPostsUseCase $findPostsUseCase;

    public function __construct()
    {
        $this->findPostsUseCase = new FindPostsUseCase();
    }

    public function handle($req, $res, $args)
    {
        $query = $req->getQueryParams()["search"] ?? "";
        $this->search = is_string($query) ? trim($query) : "";

        $posts = $this->search === "" ? [] : $this->findPostsUseCase->execute($this->search);

        $categoryController = new GetCategoriesController();
        $categories = $categoryController->handle();

        View::render("Site", "pesquisa", [
            "categories" => $categories,
            "posts" => $posts,
            "search" => $this->search
        ]);
    }
}
