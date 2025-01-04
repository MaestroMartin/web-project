<?php

declare(strict_types=1);

namespace App\UI\Post\manipulate;

use Nette\Aplication\UI\Form;


trait PresenterTrait
{
    private ?ControlFactory $postManipulateControlFactory = null;
    private array $entity = [
        'id' => 0,
    ];
    public function injectPostManipulateControlFactory(ControlFactory $controlFactory): void
    {
        $this->postManipulateControlFactory = $controlFactory;
    }

    public function createComponentPostForm(): Control
    {   
        if (!$this->getUser()->isLoggedIn()) {
            $this->error('Pro vytvoření, nebo editování příspěvku se musíte přihlásit.');
        }

        return $this->postManipulateControlFactory->create([$this, 'postFormSucceeded'], $this->entity);
    }
    public function postFormSucceeded( array $values): void
    {   
               

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('show', $values['id'] );
    }
}