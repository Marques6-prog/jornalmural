<?php

namespace Vendor\Controllers\Posts;

use Vendor\Domain\Post;
use Vendor\Domain\Category;

use Vendor\Models\Model;
use Vendor\Settings\Upload;                                                                                                                                                                                                                                                                                                             
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Repositories\CategoryRepository;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\CreatePostUseCase;

class CreatePostController extends Model implements IHandle 
{
    private Upload $_handle;
    private CreatePostUseCase $_createPostUseCase;

    public function __construct()
    {
        $this->setData($_POST);
        $this->_handle = new Upload();
        $this->_createPostUseCase = new CreatePostUseCase();
    }

    public function handle() 
    {                    
        Middleware::authenticated();

        $categoryId = intval($this->getcategory());
        $category = (new CategoryRepository())->getById($categoryId);
        if (empty($category)) {
            Application::redirect("/create-post", "?status=danger&msg=" . urlencode("Selecione uma categoria válida."));
        }

        if (
            in_array($category[0]["name"], ["Destaques", "Galeria"], true) &&
            empty($_FILES["photo"]["name"])
        ) {
            $requiredMedia = $category[0]["name"] === "Galeria" ? "uma imagem ou um vídeo" : "uma imagem";
            Application::redirect(
                "/create-post",
                "?category_id={$categoryId}&status=danger&msg=" . urlencode("Adicione {$requiredMedia} para esta publicação.")
            );
        }
        
        $post = new Post(
            $this->gettitle(),
            $this->getdescription(),
            new Category(
                "", null, null, $categoryId
            )
        );        
    
        if (
            !$post->validate()
        ) {
            Application::redirect("/create-post", "?category_id={$categoryId}&status=danger&msg=" . urlencode("Preencha devidamente os campos"));
        }

        try {
            $post->upload($this->_handle->uploadMedia($category[0]["name"] === "Galeria"));
        } catch (\InvalidArgumentException $exception) {
            $message = $category[0]["name"] === "Galeria"
                ? "Use imagens JPG/PNG ou vídeos MP4/WebM até " . Upload::MAX_VIDEO_SIZE_MB . " MB."
                : "Envie uma imagem JPG ou PNG.";
            Application::redirect(
                "/create-post",
                "?category_id={$categoryId}&status=danger&msg=" . urlencode($message)
            );
        } catch (\RuntimeException $exception) {
            error_log("Post media upload failed: " . $exception->getMessage());
            Application::redirect(
                "/create-post",
                "?category_id={$categoryId}&status=danger&msg=" . urlencode("Não foi possível guardar o ficheiro. Tente novamente.")
            );
        }

        $statusCode = $this->_createPostUseCase->execute($post);

        switch ($statusCode["status"]) {
          case 409:
            Application::redirect("/create-post", "?category_id={$categoryId}&status=danger&msg=" . urlencode("Publicação já existe"));
            break;
    
          default:
            Application::redirect("/create-post", "?category_id={$categoryId}&status=success&msg=" . urlencode("Publicação criada com sucesso!"));
            break;
        }    
    }
}