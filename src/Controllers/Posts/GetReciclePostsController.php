<?php

namespace Vendor\Controllers\Posts;

use Vendor\Manager\Middleware;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\GetReciclePostsUseCase;

class GetReciclePostsController implements IHandle 
{    
    private GetReciclePostsUseCase $_getReciclePostsUseCase;

    public function __construct()
    {               
        $this->_getReciclePostsUseCase = new GetReciclePostsUseCase();
    }

    public function handle() 
    {                    
        Middleware::authenticated();
        
        return $this->_getReciclePostsUseCase->execute();
    }
}