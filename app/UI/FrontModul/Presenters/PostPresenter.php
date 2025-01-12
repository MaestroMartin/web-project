<?php

declare(strict_types=1);

namespace App\UI\FrontModul\Presenters;

use App\UI\FrontModul\Presenters\SecurePresenterTrait;

use App\UI\Post\PostPresenter as APpresenter;


class PostPresenter extends APpresenter
{
    use SecurePresenterTrait;

    
    
}