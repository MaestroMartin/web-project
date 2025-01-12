<?php

declare(strict_types=1);

namespace App\UI\User\Sign\In;



trait PresenterTrait
{
    private ControlFactory $userSignInControlFactory;
    private string $storeRequestId= '';
    
    public function injectUserSignInFormFactory(ControlFactory $ConrtrolFactory): void
    {
        $this->userSignInControlFactory = $ConrtrolFactory;
    }
    protected function createComponentSignInForm(): Control
    {
        if (!$this->userSignInControlFactory){
            $this->error('Stránka nebyla nalezena', 404);
        }
        return $this->userSignInFormFactory->create([$this, 'onInSignFormSucces']);
    }
    public function onInSignFormSuccess(): void
    {      
        $this->flashMessage('Úspěšně přihlášeno.', 'success');
        $this->restoreRequest($this->storeRequestId);
        $this->redirect('Home:');
    }
    

}