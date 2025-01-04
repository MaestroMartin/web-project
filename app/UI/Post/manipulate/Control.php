<?php

declare(strict_types=1);

namespace App\UI\Post\manipulate;

use Nette\Application\UI\Control as C;
use Nette\Application\UI\Form;


class Control extends C
{
    /**
    * @var callable
    */

    private $onsuccess;

    public function __construct(
        private FormFactory $formFactory,
        callable $onsuccess,
        private array $entity ,
    ){}

    public function render  (): void
    {
        $this->template->render();
    }

    public function creatComponentForm()
    {
        $form = $this->formFactory->create($this->entity);
        $form->onSuccess[] = $this->onsuccess;
        return $form;
    }

}