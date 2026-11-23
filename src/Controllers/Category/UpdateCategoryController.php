<?php

namespace Vendor\Controllers\Category;

use Vendor\Models\Model;
use Vendor\Domain\Category;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\UpdateCategoryUseCase;

class UpdateCategoryController extends Model implements IHandle
{
  private UpdateCategoryUseCase $_updateCategoryUseCase;

  public function __construct()
  {
    $this->setData($_POST);
    $this->_updateCategoryUseCase = new UpdateCategoryUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    $category = new Category(
      $this->getname(),
      null,
      null,
      $this->getid()
    );

    if (
      !$category->validate()
    ) {
      Application::redirect("/category/{$this->getid()}/edit", "?status=danger&msg=Preencha devidamente os campos");
    }

    $statucCode = $this->_updateCategoryUseCase->execute(
      $category
    );

    switch ($statucCode["status"]) {
      case 400:
        Application::redirect("/category/{$this->getid()}/edit", "?status=danger&msg=Ocorreu um erro, tente novamente!");
        break;

      default:
        Application::redirect("/list-category", "?status=success&msg=Categoria actualizada com sucesso!");
        break;
    }
  }
}
