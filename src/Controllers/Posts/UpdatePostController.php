<?php

namespace Vendor\Controllers\Posts;

use Vendor\Domain\Post;
use Vendor\Domain\Category;

use Vendor\Models\Model;
use Vendor\Settings\Upload;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\{UpdatePostUseCase, GetPostByIdUseCase};

class UpdatePostController extends Model implements IHandle 
{
    private Upload $_handle;
    private UpdatePostUseCase $_updatePostUseCase;
    private GetPostByIdUseCase $_getPostByIdUseCase;

    public function __construct()
    {
        $this->setData($_POST);
        $this->_handle = new Upload();
        $this->_getPostByIdUseCase = new GetPostByIdUseCase();
        $this->_updatePostUseCase = new UpdatePostUseCase();
    }

    public function handle() 
    {                    
        Middleware::authenticated();
        
        $post = new Post(
            $this->gettitle(),
            trim($this->getdescription()),
            new Category(
                "", null, null, intval($this->getcategory())
            ), null,null, $this->getid()
        );        
    
        if (
            !$post->validate()
        ) {
            Application::redirect("/post/{$this->getid()}/update", "?status=danger&msg=Preencha devidamente os campos");
        }

        if(
            $_FILES["photo"]["name"]
        ) {
            $post->upload(
                $this->_handle->uploadPhoto()
            );
            
        }else {
            $findPost = $this->_getPostByIdUseCase->execute(
                $this->getid()
            );            
            
            $post->upload($findPost[0]["image"]);                        
        }

        $statusCode = $this->_updatePostUseCase->execute($post);

        switch ($statusCode["status"]) {
          case 400:
            Application::redirect("/list-post", "?status=danger&msg=Erro ao actualizar post");
            break;
    
          default:
            Application::redirect("/list-post", "?status=success&msg=Post actualizado com sucesso!");
            break;
        }    
    }
}