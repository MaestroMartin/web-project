<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Add;

use App\Core\FormFactory;
use App\UI\Model\CommentFacade;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\SmartObject;

class AddFormFactory
{

    use SmartObject;

    private int $postId;

    public function __construct(
        private CommentFacade $manager,
        private FormFactory $formFactory,
        private User $user,

    ){}


    public function create(int $postId): Form
    {   
        $this->postID = $postId; 

        $form = $this->formFactory->create();
        $form->getElementPrototype()->setAttribute('class', 'ajax');
        $form->addText('author', 'Author:')
            ->setRequired('Please enter your name.');

        $form->addTextArea('content', 'Comment:')
            ->setRequired('Please enter the comment.');

        $form->addSubmit('send',  'Publikovat Komentář');

        $form->onSuccess[]= [$this, 'onSuccess'];
        return $form;
    }

    public function onSuccess(Form $form, array $values){
        $values['post_id']=$this->postId;
        $values['author_id']=$this->user->id;

        $this->manager->insert($values);
    }
}
