<?php

declare(strict_types=1);

namespace App\UI\Post\Grit;

use App\UI\Model\CommentFacade;
use Nette\Application\UI\Control as C;
use App\UI\Model\PostFacade;
use App\UI\Post\Grit\item\ControlFactory;
use App\UI\Post\Grit\item\ControlMultipleTrait;
use Exception;
use Nette\Database\Table\Selection;
use Nette\Application\UI\Multiplier;

class Control extends C
{   
   public int $page = 1;
   private int $itemsPerPage = 5;
    
    public function __construct(
        private PostFacade $postFacade,
        private ControlFactory $postGridItemControlFactory ,
        private ?int $authoId,
        
    ) {
        
     }


    public function render(): void{
        
        $this->template->numOfPages = 0;
        $this->template->page = 1;
        $this->template->posts = $this->postFacade->getPublicPosts(authorId: $this->authorId)->page($this->page, $this->itemsPerPage )->fetchAll(); 
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->render();

        
    }
    public function createComponentPostGridItemMultiple()
    {
        $manager = $this->postFacade;
        $factory = $this->postGridItemControlFactory;

        return new Multiplier(function (string $id) use ($manager, $factory){
            bdump((int)$id);
            return $factory->create($manager->getById((int)$id));
            
        });
    }

    public function handlePage(int $page)
    {
        $this->page= $page;
    }

}   
