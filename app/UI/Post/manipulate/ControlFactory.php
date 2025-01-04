<?php

declare(strict_types=1);

namespace App\UI\Post\manipulate;


interface ControlFactory
{
    public function create(callable $onsuccess, array $entity ): Control;
}