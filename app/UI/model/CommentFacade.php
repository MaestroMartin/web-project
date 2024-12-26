<?php

declare(strict_types=1);


namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\SmartObject;

class CommentFacade
{
    use SmartObject;

    public function __construct(
        private Explorer $database,
    ) { }

    public function getAll(): Selection
    {
        return $this->database->table('comment');
    }

    public function getById(int $postid): ?ActiveRow
    {
        return $this->getAll()->get($postid);
    }

    public function insert(array $data): ActiveRow
    {
        return $this->getAll()->insert($data);
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