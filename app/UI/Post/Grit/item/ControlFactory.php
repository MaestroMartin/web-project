<?php

declare(strict_types=1);


namespace App\UI\Post\Grit\item;

use Nette\Database\Table\ActiveRow;


interface ControlFactory
{

    public function create(
        ActiveRow $item,
    ): Control;
    
}