<?php

declare(strict_types=1);


namespace App\UI\Post\Grit;


interface ControlFactory
{

    public function create(
       ?int $authoId
    ): Control;
    
}