<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class FindPostsUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute(string $title)
  {
    $posts = $this->postRepository->find($title);
    return $posts;
  }
}
