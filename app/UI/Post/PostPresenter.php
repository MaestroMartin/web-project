<?php

declare(strict_types=1);


namespace App\UI\Post;


use App\UI\Model\PostFacade;
use App\UI\Model\CommentFacade;
use App\UI\Model\Entity\PostResource;
use App\UI\Post\Grit\ControlTrait as T;

use App\UI\Model\Presenter;
use App\UI\Post\manipulate\PresenterTrait;
use App\UI\Post\Comment\Add\PresenterTrait as P;
use App\UI\Post\Detail\PresenterTrait as C;
use App\UI\User\Sign\In\ControlFactory;
use Nette\Database\Table\ActiveRow;

// use App\UI\Post\parrent; // This line is not needed



abstract class PostPresenter extends Presenter
{   
   
    

    private bool $canCreateCommentGrid;

    use PresenterTrait;
    use P;
    use T;
    use C;

    public function __construct(
        private PostFacade $postFacade,
        private CommentFacade $commentFacade,
        protected ControlFactory $signInControlFactory
    ) { 
        parent::__construct();
     }

    public function actionShow(int $postid)
    {
        $this->checkPrivilage('post','view');
 
        $this->template->postid = $postid;
 
             
 
        $this->post = $this->postFacade->wrapToEntity($this->checkPostExistence($postid));
         
 
        $this->canCreateCommentGrid             = $this->getUser()->isAllowed('commentGrid','view');
        $this->canCreatePostForm                = $this->getUser()->isAllowed('comment','add');
        $this->canCreatePostDetailControl       = true;
    }
    public function renderShow(int $postid): void
    {
 
        $this->template->post = $this->post;
        
 
    }

    private function checkPostExistence(int $postid)
    {
        $post= $this->postFacade->getById($postid);

        if (!$post) {
            $this->error('Příspěvek neexistuje.', 404);
            
        }
        return $post;
    }

 
    
    public function actionAdd()
    {
        

        $this->checkPrivilage('post','add');
        
        $this->canCreatePostForm = true;
    }

    public function actionEdit(int $postid)
    {
        $post = $this->checkPostExistence($postid);

        $this->checkPrivilage($this->postFacade->wrapToEntity($post),'edit' );
    
        $this->entity = $post->toArray();

        $this->canCreatePostForm = true;
    }

    
 
    public function renderManipulate(int $postid = 0)
    {
        $this->template->postid = $postid;
    }

    
    
    

    

}