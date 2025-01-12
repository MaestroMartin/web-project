<?php

declare(strict_types=1);

namespace App\UI\Model;

use App\UI\FrontModul\BasePresenter;

use App\UI\User\Sign\In\PresenterTrait;
use Nette\Application\UI\Presenter;
use Nette\SmartObject;


class SignPresenter extends Presenter
{
   
    use SmartObject;
    use PresenterTrait;
    

    public function actionIn(string $storeRequestId = '')
    {
        $this->storeRequestId = $storeRequestId ;
        if (!$storeRequestId) {
            $this->flashMessage('storeRequestId nebylo předáno nebo je prázdné.', 'error');
        }
        
    }

  
    
    public function actionOut()
    {
        $this->user->logout(true);
        $this->flashMessage('Odhlášení proběhlo úspěšně', 'success');
        $this->redirect('Home:');
    }

}