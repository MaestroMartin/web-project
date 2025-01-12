<?php

declare(strict_types=1);

namespace App\UI\Post\Grit\item;

use MultipleIterator;
use Nette\Application\UI\Control as C;
use App\UI\Model\PostFacade;
use Nette\Application\UI\Component;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class Control extends C
{   
    
    
    
    public function __construct(
         private ActiveRow $item,
        
    ) {  }


    public function render(): void{
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->item = $this->item;
        $this->template->render();
    }
    
}