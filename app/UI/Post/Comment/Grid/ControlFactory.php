<?php

declare(strict_types=1);


namespace App\UI\Post\Comment\Grid;

use App\UI\Model\PostFacade;
use Nette\Database\Table\ActiveRow;
use App\UI\Post\Comment\Grid\Control;



interface ControlFactory
{
    

    public function create(
      $postID

    ): Control;
    
}

