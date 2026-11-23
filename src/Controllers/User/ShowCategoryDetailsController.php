<?php

namespace Vendor\Controllers\User;

use Vendor\Manager\View;
use Vendor\Controllers\Category\GetCategoriesController;
use Vendor\System\Usecases\Post\GetPostsByCategoryUseCase;

class ShowCategoryDetailsController 
{
  private int $args = 0;
  private string $category = "";

  public function handle($req, $res, $args)
  {
    $this->args = intval($args["id"]);    
        
    $postUseCase = new GetPostsByCategoryUseCase();
    $posts = $postUseCase->execute();        

    $categoryController = new GetCategoriesController();
    $categories = $categoryController->handle();        
            
    $selectedCategory = array_filter($categories, function($elem) {            
        return $elem["id"] == $this->args;
    });

    $this->category = [...$selectedCategory][0]["name"];    
    
    $selectPost = array_filter($posts, function($elem) {
        return $elem["name"] == $this->category;
    });
           
    View::render("Site", "category", [
        "categories" => $categories,
        "posts" => $selectPost,
        "category" => $this->category
    ]);    
  }
}
