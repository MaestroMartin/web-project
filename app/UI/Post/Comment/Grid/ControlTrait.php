<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Grid;

use App\UI\Post\Comment\Grid\ControlFactory;

trait ControlTrait
{
    public int $postID;

    private function __construct(
        private ControlFactory $postCommentGridControlFactory,
        
        private bool $canCreateCommentGrid =false 
    ){}

    public function injectPostCommentGridControlFactory(ControlFactory $controlFactory)
    {
        $this->postCommentGridControlFactory = $controlFactory;
    }
    public function createComponentComentGrid($postID)
    {
        if (!$this->postCommentGridControlFactory||!$this->postID<1||!$this->postCommentGridControlFactory)
        {
            $this->error('stránka nebyla nalezena', 404);
        }
        return $this->postCommentGridControlFactory->create(  $postID);
    }
}