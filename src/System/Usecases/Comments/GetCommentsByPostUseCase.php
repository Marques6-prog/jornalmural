<?php

namespace Vendor\System\Usecases\Comments;

use Vendor\Repositories\CommentRepository;

class GetCommentsByPostUseCase
{
  private CommentRepository $commentRepository;

  public function __construct()
  {
    $this->commentRepository = new CommentRepository();
  }

  public function execute(int $postId)
  {
    $comments = $this->commentRepository->getById($postId);
    return $comments;
  }
}
