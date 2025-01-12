<?php

declare(strict_types=1);

namespace App\UI\Post\Comment\Grid\Item;

use App\UI\Model\CommentFacade;
use App\UI\Model\Entity\CommentResource;
use Closure;
use Nette\Application\UI\Control as C;

use Nette\Database\Table\ActiveRow;
use Nette\Security\User;

class Control extends C
{   /**
    * @var int @persistant
    * 
    */
    public int $page= 1;
    private int $itemsPerPage = 5;
    
    
    
    public function __construct(
       private CommentResource $item,
       private CommentFacade $manager,
       private User $user,
       Closure  $onDelete,
    ) {  
          
    }


    public function render(): void{
       
        $this->template->item = $this->item;
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->render();
    }
    
    public function handleDelete()
    {   
        $isAllowedToDeleteThisPost = $this->user->isAllowed($this->item, 'delete');
        if($isAllowedToDeleteThisPost){
            $this->manager->delete($this->item->id);
        
            $this->flashMessage('Nemáš dostatečná práva k přístupu do této sekce','error');
            $this->redirect('Home:');
        
        }//($this->ondelete)($isAllowedToDeleteThis);
            
    }




}