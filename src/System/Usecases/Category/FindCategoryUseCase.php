<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;

class FindCategoryUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute(string $name)
  {
    $categories = $this->categoryRepository->find($name);
    return $categories;
  }
}
