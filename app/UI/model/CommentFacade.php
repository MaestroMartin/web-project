<?php

declare(strict_types=1);


namespace App\UI\Model;

use App\UI\Model\BaseManager;
use App\UI\Model\Entity\CommentResource;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class CommentFacade extends BaseManager
{
    public function getTableName(): string
    {
        return 'comments';
    }

    public function getCommentsByPostId(int $postId, int $limit = null): Selection
    {
        return $this->getAll()
            ->where('post_id', $postId)
            ->order('created_at DESC')
            ->limit($limit);
        
    }
    public function delete(int $id)
    {
        $this->getById($id)->delete();

    }

    public function wrapToEntity(ActiveRow $row): CommentResource    
    {
        return CommentResource::create($this->getTableName(), $row);
    }

}