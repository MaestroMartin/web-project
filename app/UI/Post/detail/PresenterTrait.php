<?php

declare(strict_types=1);


namespace App\UI\Post\Detail;

use App\UI\Model\Entity\PostResource;
use Closure;

trait PresenterTrait
{
    private ControlFactory $postDetailControlFactory;
    protected PostResource $post;
    private bool $canCreatePostDetailControl = false;
  

    public function injectPostDetailControlFactory(ControlFactory $controlFactory)
    {
        $this->postDetailControlFactory = $controlFactory;    
    }

    public function createComponentPostDetailControl()
    {
        if (!$this->canCreatePostDetailControl||!$this->post||!$this->postDetailControlFactory){
            $this->error('stránka nebyla nalezena',404);
        }
        
        return $this->postDetailControlFactory->create($this->post, Closure::fromCallable([$this,'onPostDelete']) );
    }

    public function onPostDelete(bool $isOk)
    {   
        if ($isOk){
            $this->flashMessage('Přízpěvek byl úspěšně smazán', 'succes');
            $this->redirect('home:default');
        }
        $this->error('nejste oprávněn smazat tento přízpěvek',   \Nette\Http\IResponse::S403_Forbidden);
        
    }
}