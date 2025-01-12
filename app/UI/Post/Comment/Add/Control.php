<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Add;


use Nette\Application\UI\Control as C;
use Nette\Application\UI\Form;


class Control extends C
{  

    public function __construct(
        private AddFormFactory $addFormFactory ,
        private int $postId,
        callable $onSucces,
    ) { 
        $this->onSucces = $onSucces;
    }


    public function render(): void{
        
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->render();
    }
    public function createComponentForm():Form
    {
        $form = $this->addFormFactory->create($this->postId);
        $form->onSubmit[]= [$this, 'onSubmit'];
        $form->onSuccess[] = $this->onSuccess;

        return $form;
    }
    
    public function onSubmit()
    {
        $this->redrawControl('form');
    }

}