<?php

declare(strict_types=1);

namespace App\UI\User\Sign\In;

use Nette\Application\UI\Form;
use Nette\Application\UI\Control as C;

class Control extends C
{
   /**
    *@var callable 
    */

    private $onSuccess;

   public function __construct(
        private FormFactory $userSigninformFactory,
        private FormFactory $formFactory,
         callable $onSuccess,
    )
    {
        $this->onSuccess = $onSuccess;
    }

    public function render(): void
    {
        $this->template->setFile(__DIR__ . '/formdefault.latte');
        $this->template->render();
    }

    protected function createComponentForm(): Form{

        $form = $this->userSigninformFactory->create();

        $form->onSubmit[]= [$this, 'onSubmit'];
        $form->onSuccess[] = $this->onSuccess;

        return $form;

    }
    public function onSubmit()
    {
        $this->redrawControl('form');
    }
    
}