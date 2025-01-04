<?php

declare(strict_types=1);

namespace App\UI\Post\Grit;

use Nette\Application\UI\Control as C;
use App\UI\Model\PostFacade;
use App\UI\Post\Grit\item\ControlFactory;
use App\UI\Post\Grit\item\ControlMultipleTrait;

class Control extends C
{   


    use ControlMultipleTrait;
    public function __construct(
        private PostFacade $postFacade,
        private ControlFactory $controlFactory,
    ) {
        $this->template->posts = $this->postFacade->getPublicPosts(5);
        $this->injectPostGritItemControlFactory($this->controlFactory);
     }


    public function render(): void{
        $this->template->setFile(__DIR__ . '/default.latte');
        
        $this->template->render();
    }

}   
