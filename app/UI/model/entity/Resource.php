<?php

declare(strict_types=1);

namespace App\UI\Model\Entity;

use Nette\Database\Table\ActiveRow;
use Nette\Security\Resource as NSResource;

abstract class Resource implements NSResource
{

    public function __construct(
        private string $resourceId,
        protected ActiveRow $resource,
        
    ){}



    function getResourceId(): string
    {
        return $this->resourceId;
    }

    
    public static function create(string $resourceId, ActiveRow $resource):static
    {
        return new static($resourceId,$resource);
    }

    public function __get(string $name)
    {
        return $this->resource->$name;
    }
}