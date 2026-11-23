<?php

namespace Vendor\System\Usecases\Comments;

use Vendor\Domain\Contracts\IDomainDto;
use Vendor\Repositories\CommentRepository;

class AddCommentIntoPostUseCase
{
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function execute(IDomainDto $request)
    {
        $statement = $this->commentRepository->save($request);

        if ($statement) {
            return [
                "status" => 201 // Comment successfully added,
            ];
        }
    }
}
