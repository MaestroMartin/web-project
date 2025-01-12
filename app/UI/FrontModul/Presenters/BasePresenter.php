<?php

declare(strict_types=1);

namespace App\UI\FrontModul;

use App\Admin\Presenters\SecurePresenterTrait as PresentersSecurePresenterTrait;


use Nette\Application\UI\Presenter;
use Nette\Database\Explorer;
use Nette\DI\Attributes\Inject;

abstract class BasePresenter extends Presenter
{
    use PresentersSecurePresenterTrait;

    #[Inject] public  Explorer $db;

    public function actionTestdb()
    {
        $user= $this->db->query('SELECT* FROM user');

        die();
    }
    
}   
