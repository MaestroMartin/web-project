<?php

declare(strict_types=1);

namespace App\UI\Post\Grit\item;

use Nette\Application\UI\Control as C;
use App\UI\Model\PostFacade;
use Nette\Database\Table\ActiveRow;

class Control extends C
{   
    public function __construct(
        private PostFacade $postFacade,
        private ActiveRow $item
    ) { }


    public function render(): void{
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->post = $this->item;
        $this->template->render();
    }
}