<?php

declare(strict_types=1);

namespace App\UI\FrontModul\Presenters\Template;


use App\UI\FrontModul\Presenters\SecurePresenterTrait;
use App\UI\Model\SignPresenter as ModelSignPresenter;



class SignPresenter extends ModelSignPresenter
{
    use SecurePresenterTrait;
}