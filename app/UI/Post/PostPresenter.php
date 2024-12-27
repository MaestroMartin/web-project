<?php

declare(strict_types=1);


namespace App\UI\Post;

use Nette\Application\UI\Presenter;
use App\Model\PostFacade;
use App\Model\CommentFacade;
use Nette\Application\UI\Form;
use Nette;

class PostPresenter extends Presenter
{   


    public function __construct(
        private PostFacade $postFacade,
        private CommentFacade $commentFacade,
    ) { }

    public function actionManipulate(int $postid = 0): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro tuto akci je nutné se přihlásit.', 'error');
            $this->redirect('Sign:in', $this->storeRequest());
        }

        if ($postid == 0) {
            return;
        }

        $post = $this->postFacade->getById($postid);
        if (!$post) {
            $this->error('Omlouváme se, ale Vámi zvolený příspěvek neexistuje!!!', 404);
        }
        $this['postForm']->setDefaults($post->toArray());
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

    protected function createComponentPostForm(): Form
    {
        $form = new Form;
        $form->addText('title', 'Titulek:')
            ->setRequired();
        $form->addTextArea('content', 'Obsah:')
            ->setRequired();

        $form->addSubmit('send', 'Uložit a publikovat');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];

        return $form;
    }

    public function postFormSucceeded(Form $form, array $values): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->error('Pro vytvoření, nebo editování příspěvku se musíte přihlásit.');
        }

        $postId = $this->getParameter('postId');

        if ($postId) {
            $post = $this->postFacade->getById($postId);
            $post->update($values);
        } else {
            $post = $this->postFacade->insert($values);
        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('show', $post->id);
    }

}