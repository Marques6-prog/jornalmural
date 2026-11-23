<?php

namespace Vendor\Controllers\Comments;

use Vendor\Models\Model;
use Vendor\Manager\Application;
use Vendor\Domain\{Comments, Post};
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Comments\AddCommentIntoPostUseCase;

class AddCommentIntoPostController extends Model implements IHandle
{
    private AddCommentIntoPostUseCase $_addCommentIntoPost;

    public function __construct()
    {
        $this->setData($_POST);
        $this->_addCommentIntoPost = new AddCommentIntoPostUseCase();
    }

    public function handle()
    {
        $comment = new Comments(
            $this->getusername(),
            $this->getdescription(),
            new Post("", "", null, null, null, $this->getid())
        );

        if (
            !$comment->validate()
        ) {
            Application::redirect("/details/{$this->getid()}", "?status=danger&msg=Adicione um comentário");
        }

        $statusCode = $this->_addCommentIntoPost->execute($comment);

        switch ($statusCode["status"]) {
            case 201:
                Application::redirect("/details/{$this->getid()}", "?status=success&msg=Comentário adicionado!");
                break;

            default:
                Application::redirect("/details/{$this->getid()}", "?status=danger&msg=Erro ao comentar");
                break;
        }
    }
}
