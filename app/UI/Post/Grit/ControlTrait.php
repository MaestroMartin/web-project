<?php

declare(strict_types=1);    


namespace App\UI\Post\Grit;

use App\UI\Model\PostFacade;
use App\UI\Post\grit\ControlFactory; // Ensure this path is correct and the class exists



trait ControlTrait
{
    private ControlFactory $postGritControlFactory;
    private ?int $authorId = null;
    
    
    
    public function injectPostGritControlFactory(ControlFactory $ControlFactory): void
    {
        $this->postGritControlFactory = $ControlFactory;
    }
    protected function createComponentPostGrid()
    {
        if (
            !$this->postGritControlFactory
        ){
            $this->error('stránka nebyla nalezena',404);
        }
        return $this->postGritControlFactory->create($this->authorId);
    }   
}