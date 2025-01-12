<?php

declare(strict_types=1);


namespace App\UI\Post\Comment\Add;

use App\UI\Model\PostFacade;
use Nette\Database\Table\ActiveRow;
use App\UI\Post\Comment\Add\Control;



interface ControlFactory
{

    public function create(
        int $postID,
      
    ): Control;
    
    
}
