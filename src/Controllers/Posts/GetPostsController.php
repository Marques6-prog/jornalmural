<?php

namespace Vendor\Controllers\Posts;

use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\GetPostsUseCase;

class GetPostsController implements IHandle
{
    private GetPostsUseCase $_getPostsUseCase;

    public function __construct()
    {
        $this->_getPostsUseCase = new GetPostsUseCase();
    }

    public function handle()
    {
        return $this->_getPostsUseCase->execute();
    }
}
