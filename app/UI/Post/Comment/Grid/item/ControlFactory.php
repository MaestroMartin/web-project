<?php

declare(strict_types=1);


namespace App\UI\Post\Comment\Grid\item;

use App\UI\Model\Entity\CommentResource;
use Nette\Database\Table\ActiveRow;
use App\UI\Post\Comment\Grid\Item\Control;
use Closure;

interface ControlFactory
{

    public function create(
        CommentResource $item,
        Closure $onDelete
    ): Control;
    
}