<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class GetPostByIdUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute(int $id)
  {
    $post = $this->postRepository->getById($id);
    return $post;
  }
}
