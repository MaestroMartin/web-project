<?php

declare(strict_types=1);

namespace App\UI\Post\Detail;

use App\UI\Model\Entity\PostResource;
use App\UI\Model\PostFacade;
use Closure;
use Nette\Application\UI\Control as C;
use Nette\Security\User;

class Control extends C
{
    

    public function __construct(
        private PostResource $item,
        private PostFacade $manager,
        private Closure $ondelete,
        private User $user,
        ){   
    }

    public function render(): void
    {
        $this->template->item = $this->item;
        $this->template->setFile(__DIR__ . '/default.latte');
        $this->template->render();
    }

    public function handleDelete()
    {   
        $isAllowedToDeleteThis = $this->user->isAllowed($this->item, 'delete');
        if($isAllowedToDeleteThis){
            $this->manager->delete($this->item->id);

            $this->flashMessage('Nemáš dostatečná práva k přístupu do této sekce','error');
            $this->redirect('Home:');
        }
        //($this->ondelete)($isAllowedToDeleteThis);
    }
}
