<?php

declare(strict_types=1);

namespace   App\UI\Model\Entity;

use Nette\Security\Role as IRole;



class Role implements IRole
{
    private int $authorId;
    public function __construct(
        private int $userId,
        private string $roleId,
        
    )
    {}

    function getRoleId(): string
    {
        return $this->roleId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public static function create(int $userId, string $roleId)
    {
        return new Role($userId, $roleId);
    }

    public function getAuthorId(): int

    {

        return $this->authorId;

    }

}