<?php

declare(strict_types=1);

namespace App\UI\User\Sign\In;

use App\UI\Home\BasePresenter;
use App\UI\User\Sign\In\FormFactory;
use Nette\Application\UI\Form;

trait PresenterTrait
{
    private ControlFactory $userSignInControlFactory;
    
    public function injectUserSignInFormFactory(ControlFactory $ConrtrolFactory): void
    {
        $this->userSignInControlFactory = $ConrtrolFactory;
    }
    protected function createComponentSignInForm(): Control
    {
        return $this->userSignInFormFactory->create();
    }
    public function onInSignFormSuccess(): void
    {      
        $this->flashMessage('Úspěšně přihlášeno.', 'success');
        $this->restoreRequest($this->storeRequestId);
        $this->redirect('Home:');
    }
}