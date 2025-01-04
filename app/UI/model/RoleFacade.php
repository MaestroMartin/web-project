<?php

declare(strict_types=1);

namespace App\UI\Model;

use App\UI\Model\BaseManager;
use Nette\Database\Table\Selection;

class RoleFacade extends BaseManager
{
    public function getTableName(): string
    {
        return 'role'; 
    }

    public function findByUserId(int $id): selection
    {
        return $this->getAll()
        ->where('user_x_role.user_id', $id);
        
    }

    public function findByUserIdToSelect(int $id): array
    {
        return $this->findByUserId($id)
        ->fetchPairs('id', 'name');
        
    }
}