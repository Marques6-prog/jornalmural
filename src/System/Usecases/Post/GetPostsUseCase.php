<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class GetPostsUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute()
  {
    $posts = $this->postRepository->get();
    return $posts;
  }
}
