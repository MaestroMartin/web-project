<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Grid;

use App\UI\Model\CommentFacade;
use Nette\Application\UI\Control as C;
use App\UI\Model\PostFacade;
use Closure;
use Nette\Application\UI\Component;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;


class Control extends C
{   /**
    * @var int @persistant
    * 
    */
    public int $page= 1;
    private int $itemsPerPage = 5;
    
    

    public function __construct(
        private ControlFactory $controlFactory,
        private CommentFacade $commentFacade,
        private int $postid,
        
    ) { }


    public function render(): void{
        $this->comments = $this->commentFacade->getCommentsByPostId($this->postId)->page( $this->page,$this->itemsPerPage);
        $this->template->numOfPages =0;
        $this->template->page = $this->page;
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->render();
    }
    public function createComponentPostGridItemMultiple():Component
    {
        $manager = $this->manager;
        $factory = $this->controlFactory;
        $onDeleteCallBack = Closure::fromCallable([$this, 'onCommentDelete']);

        return new Multiplier(function (string $id) use ($manager,$factory){
            return $factory->create(
                $manager->wrapToEntity($manager->getById((int)$id)),
                $onDeleteCallBack,
            );
                
        });
    }

    public function onCommentDelete(bool $isOk)
    {   
        if($isOk){
            $this->flashMessage('smazání komentáře proběhlo úspěšně','succes');
            $this->redrawControl('comments');
        }else{
            $this->flashMessage('pro smazání komentáře nemáte práva', 'error');
        }

        $this->redrawControl('flashes');
        
    }




    public function handleLoadMore():void
    {
        $this->page += 1;
        $this->redrawControl('comments');
    }

}