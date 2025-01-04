<?php

declare(strict_types=1);

namespace App\UI\Home;


use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
abstract class BasePresenter extends Presenter
{
    private string $storeRequestId = '';
    public function startup(): void
    {
        parent::startup();
        $this->template->user = $this->getUser();
    }
    protected function createComponentSignInForm(): Form
    {
        return $this->userSignInFormFactory->create();
    }
    public function onInSognFormSuccess(): void
    {      
        $this->flashMessage('Úspěšně přihlášeno.', 'success');
        $this->restoreRequest($this->storeRequestId);
        $this->redirect('Home:');
    }
}   
