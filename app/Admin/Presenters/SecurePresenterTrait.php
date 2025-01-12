<?php

declare(strict_types=1);

namespace App\Admin\Presenters;

Trait SecurePresenterTrait
{
    public function startup(): void{

        if (!$this->isLinkCurrent('Sign:in') &&!$this->user->isAllowed('admin','view')){
            $this->flashMessage('musíš být přihlášen', 'error');
            $this->redirect('Sign:in');
        }
        parent::startup();
    }
}