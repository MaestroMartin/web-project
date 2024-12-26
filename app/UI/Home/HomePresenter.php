<?php

declare(strict_types=1);

namespace App\UI\Home;

use App\Model\PostFacade;
use Nette\Application\UI\Presenter;
use Nette;


final class HomePresenter extends Presenter
{
    public function __construct(
        private PostFacade $postFacade,
    ) { }

    public function renderDefault()
    {
        $this->template->posts = $this->postFacade->getPublicPosts(5);
    }
}
