<?php

declare(strict_types=1);

namespace App\UI\FrontModul\Presenters;

use Nette\Security\User;

Trait SecurePresenterTrait
{
    

    public function __construct(
        private User $user,
        
    ){

    }

    public function startup(): void
    {
        if (!$this->isLinkCurrent('Sign:in') && !$this->user->isAllowed('front','view')){
            $this->flashMessage('Nemáš dostatečná práva k přístupu do této sekce','error');
            $this->redirect('Sign:in');
        }
        parent::startup();
    }
}