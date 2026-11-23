<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;
use Vendor\Domain\Contracts\IDomainDto;

class CreateCategoryUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute(IDomainDto $request)
  {
    $categoryAlreadyExists = $this->categoryRepository->getUserByName(
      $request->name
    );

    if ($categoryAlreadyExists) {
      return [
        "status" => 409 // Category Already Exists,
      ];
    }

    $statement = $this->categoryRepository->save($request);

    if ($statement) {
      return [
        "status" => 201 // Category successfully created,
      ];
    }
  }
}
