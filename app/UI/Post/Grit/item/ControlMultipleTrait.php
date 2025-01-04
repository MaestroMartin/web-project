<?php

declare(strict_types=1);    


namespace App\UI\Post\Grit\item;

use App\UI\Model\PostFacade;
use App\UI\Post\grit\item\ControlFactory; // Ensure this path is correct and the class exists
use Nette\Database\Table\ActiveRow;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\Selection;

trait ControlMultipleTrait
{
    private Selection $posts;

    public function __construct(
        private PostFacade $postFacade,
        private ActiveRow $postGridItem,
        
    )
    {}

    private ControlFactory $postGridItemControlFactory;
    
    
    public function injectPostGritItemControlFactory(ControlFactory $ControlFactory): void
    {
        $this->postGridItemControlFactory = $ControlFactory;
    }

    public function createComponentPostGridItemMultiple()
    {
        $posts = $this->posts;
        $factory = $this->postGridItemControlFactory;
        return new Multiplier(function (string $id) use ($posts, $factory){
            return $factory->create($posts[(int) $id]);
        });
    }
}