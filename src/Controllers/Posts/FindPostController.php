<?php

namespace Vendor\Controllers\Posts;

use Vendor\Manager\Middleware;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\FindPostsUseCase;

class FindPostController implements IHandle 
{
    private string $_title;
    private FindPostsUseCase $_findPostsUseCase;

    public function __construct(string $title)
    {       
        $this->_title = $title;
        $this->_findPostsUseCase = new FindPostsUseCase();
    }

    public function handle() 
    {                    
        Middleware::authenticated();
        
        return $this->_findPostsUseCase->execute($this->_title);
    }
}