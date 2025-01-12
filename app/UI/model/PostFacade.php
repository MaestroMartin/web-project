<?php

declare(strict_types=1);

namespace App\UI\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use App\UI\Model\BaseManager;
use App\UI\Model\Entity\PostResource;


class PostFacade extends BaseManager
{
    use SmartObject;


    public function __construct(
        Explorer $database,
        private MailSender $mailSender,
        protected PostFacade $postFacade
       
    ) {
        parent::__construct($database);
    }

    public function getTableName(): string
    {
        return 'post';
    }

    public function insert(array $values): ActiveRow
    {      

        $retVal = parent::insert($values);

         
        $this->mailSender->sendPostInserted($retVal->toArray());	
         

        return $retVal; 
    }

    

    public function getPublicPosts(int $limit = null, ?int $authorId= null ): Selection
    {
        return $this->getAll()
            ->where('created_at <',new DateTime)
            ->order('created_at DESC')
            ->limit($limit);

        if ($authorId){
            $retVal->where('author_id',$authorId);
        }
        return $retVal;
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


    public  function wrapToEntity(ActiveRow $row):PostResource
    {
       
        return PostResource::create($this->getTableName(), $row);
    }

    public function delete(int $id){
        $this->getById($id)->delete();
    }
}
