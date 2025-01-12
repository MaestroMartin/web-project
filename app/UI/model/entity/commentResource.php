<?php

declare(strict_types=1);

namespace App\UI\Model\Entity;

class CommentResource extends Resource
{
    public function getPostAuthorId()
    {
        return $this->resource->post->author_id;
    }
    
    
}