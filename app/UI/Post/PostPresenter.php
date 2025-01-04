<?php

declare(strict_types=1);


namespace App\UI\Post;

use App\UI\Home\BasePresenter;
use App\UI\Model\PostFacade;
use App\UI\Model\CommentFacade;
use App\UI\Post\manipulate\PresenterTrait;
use Nette\Application\UI\Form;


class PostPresenter extends BasePresenter
{   
    use PresenterTrait;

    public function __construct(
        private PostFacade $postFacade,
        private CommentFacade $commentFacade,
    ) { }
    
    private function checkPrivilageManipulate()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro tuto akci je nutné se přihlásit.', 'error');
            $this->redirect('Sign:in', $this->storeRequest());
        }
    }
    
    public function actionAdd()
    {
        $this->checkPrivilageManipulate();
       
    }

    public function actionEdit(int $postId = 0): void
    {
        $this->checkPrivilageManipulate();
        
        $post = $this->postFacade->getById($postId);
        if (!$post) {
            $this->error('Omlouváme se, ale Vámi zvolený příspěvek neexistuje!!!', 404);
        }
        $this->entity = $post->toArray();
    }

    public function renderManipulate(int $postid = 0)
    {
        $this->template->postid = $postid;
    }

    public function renderShow(int $postid): void
    {
        $post = $this->postFacade->getById($postid);

        if (!$post) {
            $this->error('Omlouváme se, ale Vámi zvolený příspěvek neexistuje!!!', 404);
        }

        $this->template->post = $post;
        $this->template->comments = $this->commentFacade->getCommentsByPostId($postid);
    }

    protected function createComponentCommentForm(): Form
    {
        $form = new Form();

        $form->addText('name', 'Jméno:')
            ->setRequired();

        $form->addEmail('email', 'E-mail:');

        $form->addTextArea('content', 'Komentář:')
            ->setRequired();

        $form->addSubmit('send', 'Publikovat komentář');

        $form->onSuccess[] = [$this, 'commentFormSucceeded'];

        return $form;
    }

    public function commentFormSucceeded(Form $form, \stdClass $data): void
    {
        $postId = $this->getParameter('postid');

        $this->commentFacade->insert([
            'post_id' => $postId,
            'name' => $data->name,
            'email' => $data->email,
            'content' => $data->content,
        ]);

        $this->flashMessage('Děkuji za komentář', 'success');
        $this->redirect('this');
    }    

}