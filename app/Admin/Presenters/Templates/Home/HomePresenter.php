<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters\Templates\Home;

use App\AdminModule\Presenters\BasePresenter;
use App\UI\Post\Grit\ControlTrait as ComponentsPostGridPresenterTrait;

class HomePresenter extends BasePresenter
{
    use ComponentsPostGridPresenterTrait;

    public function actionDefault()
    {
        $this->authorId = $this->user->id;
    }
}