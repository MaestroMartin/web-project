<?php

declare(strict_types=1);


namespace App\UI\Model;

use App\UI\Model\BaseManager;
use Nette\Database\Explorer;
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
        $retVal = $this->getAll()
            ->where('post_id', $postId)
            ->order('created_at');

        if ($limit) {
            $retVal->limit($limit);
        }

        return $retVal;
    }
}