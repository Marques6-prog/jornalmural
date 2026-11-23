<?php

namespace Vendor\Controllers\Posts;

use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\GetPostByIdUseCase;

class GetPotsByIdController implements IHandle 
{
    private int $_id;
    private GetPostByIdUseCase $_getPostByIdUseCase;

    public function __construct(int $id)
    {       
        $this->_id = $id;
        $this->_getPostByIdUseCase = new GetPostByIdUseCase();
    }

    public function handle() 
    {                                    
        return $this->_getPostByIdUseCase->execute($this->_id);
    }
}