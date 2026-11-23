<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;

class GetCategoryByIdUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute(int $id)
  {
    $categorie = $this->categoryRepository->getById($id);
    return $categorie;
  }
}
