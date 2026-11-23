<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;
use Vendor\Domain\Contracts\IDomainDto;

class UpdatePostUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute(IDomainDto $request)
  { 
    $statement = $this->postRepository->update($request);

    if ($statement) {
      return [
        "status" => 200 // Post successfully created,
      ];
    }

    return [
       "status" => 400 // Bad Request
    ];
  }
}
