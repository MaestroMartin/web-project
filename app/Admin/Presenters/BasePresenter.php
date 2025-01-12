<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Admin\Presenters\SecurePresenterTrait;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    use SecurePresenterTrait;
}