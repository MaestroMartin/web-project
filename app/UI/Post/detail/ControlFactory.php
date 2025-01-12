<?php

declare(strict_types=1);

namespace App\UI\Post\Detail;

use App\UI\Model\Entity\PostResource;
use Nette\Database\Table\ActiveRow;
use App\UI\Model\Entity\Resource;
use Closure;

interface ControlFactory
{
    public function create(
        PostResource $item,
        Closure $onDelete,
    ):Control;
    
}
