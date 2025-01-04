<?php

declare(strict_types=1);    

namespace App\UI\Model;

use App\UI\Model\BaseManager;
use Nette\Database\Table\ActiveRow;

class UserFacade extends BaseManager
{
    public function getTableName(): string
    {
        return 'user';
    }

    public function getUserByEmail(string $email): ?ActiveRow
    {
        return $this->getAll()
        ->where('email', $email)
        ->fetch();
    }
}   