<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Add;

use App\UI\Post\Comment\Add\ControlFactory;


trait PresenterTrait
{
    private ControlFactory $postCommentControlFactory;
    private int $postID = 0;
    private bool $canCreatCommentForm = false;
    public function injectPostCommentControlFactory(ControlFactory $controlFactory)
    {
        $this->postCommentControlFactory = $controlFactory;
    }
    public function createComponentCommentForm()
    {   
        if ($this->canCreatCommentForm||!$this->postID<1 ||!$this->postCommentControlFactory){

            $this->error('stránka nebyla nalezena', 404);
        }
        return $this->postCommentControlFactory->create( $this->postID);
    }

    public function postCommentFormSucceded()
    {
        $this->flashMessage('Děkuji za komentář','success');
        $this->redirect('this');
    }
}