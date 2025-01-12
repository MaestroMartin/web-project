<?php

declare (strict_types=1);


namespace App\UI\Model;

use App\UI\Model\Entity\CommentResource;
use Nette\StaticClass;
use Nette\Security\Permission;
use App\UI\Model\Entity\Role;

class AuthorizatorFactory
{
    
    
    public static function create(): Permission
    {
        $acl = new Permission;
        $acl->addRole('gues');
        $acl->addRole('user', 'guest');
        $acl->addRole('moderator','gusest');
        $acl->addRole('admin');


        $acl->addResource('front'); //view,, logout,register
        $acl->addResource('admin'); //view, logout
        
        $acl->addResource('postGrid'); //view
        $acl->addResource('post'); //view, add, edit, delete
        $acl->addResource('commentGrid'); //view
        $acl->addResource('comment'); //view, edit, delete
        
        
        
        $acl->deny('gusest');
        $acl->allow('gusest','front', 'view');
        $acl->allow('gusest','post', 'view');
        $acl->allow('gusest','postGrid', 'view');
        $acl->allow('gusest','post', 'view');
        $acl->allow('gusest','commentGrid','view');
        $acl->allow('gusest','comments','view');

        $acl->allow('user','comments', 'add');
        $acl->allow('user','comments', 'edit',[self::class, 'checkResourceManipulateAsAuthor']);
        $acl->allow('user','comments', 'delete',[self::class, 'checkCommentDelete']);
        $acl->allow('user','front','logout');

        $acl->allow('moderator','post','add');
        $acl->allow('moderator','post','edit', [self::class, 'checkResourceManipulateAsAuthor']);
        $acl->allow('moderator','post','delete',[self::class, 'checkResourceManipulateAsAuthor']);
        $acl->allow('moderator','admin','view');
        $acl->allow('moderator','admin','logout');
        $acl->allow('admin');

        $acl->allow('admin');

        $acl->isAllowed();

        return $acl;
    }
    public static function checkResourceManipulateAsAuthor(Permission $acl, string $role,string $resource, string $privilege)
    {
        $role = $acl->getQueriedRole();
        if (!$role instanceof Role) {
            throw new \InvalidArgumentException('Queried role must be an instance of Role');
        }
        $resource = $acl->getQueriedResource();
        
        return $role->getUserId() === $resource->author_id;
    }

    public function checkCommentDelete(Permission $acl, string $role,string $resource, string $privilege)
    {
        $queriedRole = $acl->getQueriedRole();
        if (!$queriedRole instanceof Role) {
            throw new \InvalidArgumentException('Queried role must be an instance of Role');
        }
        
        $queriedResource = $acl->getQueriedResource();
        if (!$queriedResource instanceof CommentResource) {
            throw new \InvalidArgumentException('Queried role must be an instance of Role');
        }
        
        return self::checkResourceManipulateAsAuthor($acl,$role,$resource,$privilege) || $queriedRole->getUserId() === $queriedResource->getPostAuthorId();
    }
}