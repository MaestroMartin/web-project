<?php

declare(strict_types=1);

namespace App\UI\User\Sign\In;


interface ControlFactory
{

    public function create(callable $onSuccess): Control;
    
}