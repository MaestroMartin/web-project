<?php

declare(strict_types=1);    


namespace App\UI\Post\Grit\item;

use App\UI\Model\PostFacade;
use App\UI\Post\grit\item\ControlFactory; // Ensure this path is correct and the class exists
use Nette\Database\Table\ActiveRow;

trait ControlOneTrait
{
    public function __construct(
        private PostFacade $postFacade,
        private ActiveRow $postGridItem)
    {}

    private ControlFactory $postGridItemControlFactory;
    
    
    public function injectPostGritItemControlFactory(ControlFactory $ControlFactory): void
    {
        $this->postGridItemControlFactory = $ControlFactory;
    }
    protected function createComponentPostGrid(): Control
    {
        return $this->postGridItemControlFactory->create($this->postGridItem);
    }   
}