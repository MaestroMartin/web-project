<?php

namespace App\UI\sign;

use App\UI\Home\BasePresenter;




class SignPresenter extends BasePresenter
{

    public function actionIn(string $storeRequestId = '')
    {
        $this->storeRequestId = $storeRequestId;
    }

    public function actionOut()
    {
        $this->user->logout(true);
        $this->flashMessage('Odhlášení proběhlo úspěšně', 'success');
        $this->redirect('Home:');
    }
}