<?php

declare(strict_types=1);

namespace App\UI\Model;

use Nette\SmartObject;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\Database\Table\ActiveRow;


abstract class BaseManager{

    use SmartObject;

    public function __construct(
        protected Explorer $database,
        
    ) {}
    
    public abstract function getTableName(): string;

        
    public function getAll(): Selection
    {
        return $this->database->table($this->getTableName());
    }

    public function getById(int $postid): ?ActiveRow
    {
        return $this->getAll()->get($postid);
    }

    public function insert(array $data): ActiveRow
    {
        return $this->getAll()->insert($data);
    }
}