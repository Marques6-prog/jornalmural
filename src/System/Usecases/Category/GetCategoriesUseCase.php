<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;

class GetCategoriesUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute()
  {
    $categories = $this->categoryRepository->get();
    return $categories;
  }
}
