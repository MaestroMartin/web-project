<?php

declare(strict_types=1);

namespace App\Admin\Presenters;



use App\UI\Post\PostPresenter as APpresenter;
use App\UI\Post\manipulate\PresenterTrait as CommentsPostManipulatePresenterTrait ;


class PostPresenter extends APpresenter
{
    use CommentsPostManipulatePresenterTrait;
    use SecurePresenterTrait;



    public function actionShow(int $postId)
    {
        parent::actionShow($postId);

        if ($this->post->author_id !== $this->user->id){
            $this->flashMessage('musíš být přihlášen', 'error');
            $this->redirect('Sign:in');
        }
    }

    public function actionAdd()
    {
        

        $this->checkPrivilage('post','add');
        
        $this->canCreatePostForm = true;
    }

    public function actionEdit(int $postid)
    {
        $post = $this->checkPostExistence($postid);

        $this->checkPrivilage($this->postFacade->wrapToEntity($post),'edit' );
    
        $this->entity = $post->toArray();

        $this->canCreatePostForm = true;
    }

   
 
    public function renderManipulate(int $postid = 0)
    {
        $this->template->postid = $postid;
    }

    public function renderShow(int $postid): void
    {

        $this->template->post = $this->post;
        $this->template->comments = $this->commentFacade->getCommentsByPostId($postid);

    }

    private function checkPostExistence(int $postid)
    {
        $post= $this->postFacade->getById($postid);

        if (!$post) {
            $this->error('Příspěvek neexistuje.', 404);
            
        }
        return $post;
    }

    
    
}