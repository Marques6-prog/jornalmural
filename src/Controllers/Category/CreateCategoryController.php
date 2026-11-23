<?php

namespace Vendor\Controllers\Category;

use Vendor\Models\Model;
use Vendor\Domain\Category;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\CreateCategoryUseCase;

class CreateCategoryController extends Model implements IHandle
{
  private CreateCategoryUseCase $_createCategoryUseCase;

  public function __construct()
  {
    $this->setData($_POST);
    $this->_createCategoryUseCase = new CreateCategoryUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    $category = new Category(
      $this->getname()
    );

    if (
      !$category->validate()
    ) {
      Application::redirect("/create-category", "?status=danger&msg=Preencha devidamente os campos");
    }

    $statucCode = $this->_createCategoryUseCase->execute(
      $category
    );

    switch ($statucCode["status"]) {
      case 409:
        Application::redirect("/create-category", "?status=danger&msg=Categoria já existe");
        break;

      default:
        Application::redirect("/create-category", "?status=success&msg=Categoria criada com sucesso!");
        break;
    }
  }
}
