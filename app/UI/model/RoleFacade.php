<?php

declare(strict_types=1);

namespace App\UI\Model;

use App\UI\Model\BaseManager;
use Nette\Database\Table\Selection;
use App\UI\Model\entity\Role;

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

    public function findByUserIdToSelect(int $id, bool $returnAsEntity= false): array
    {
        $retVal= $this->findByUserId($id)
        ->fetchPairs('id', 'name');
        return $retVal;
    }


    public function findAllByUserIdAsEntity(int $id)
    {
        return array_map(
            function(string $name) use ($id){
                return  Role::create($id,$name);
            },
            $this->findByUserIdToSelect($id),
        );
    }
} 