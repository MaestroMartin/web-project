<?php

declare(strict_types=1);    


namespace App\UI\Post\Grit;

use App\UI\Model\PostFacade;
use App\UI\Post\grit\ControlFactory; // Ensure this path is correct and the class exists



trait ControlTrait
{
    public function __construct(
        private PostFacade $postFacade,
    )
    {}

    private ControlFactory $postGridControlFactory;
    
    
    public function injectPostGritControlFactory(ControlFactory $ControlFactory): void
    {
        $this->postGridControlFactory = $ControlFactory;
    }
    protected function createComponentPostGrid(): Control
    {
        return $this->postGridControlFactory->create();
    }   
}