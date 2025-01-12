<?php

declare(strict_types=1);

namespace App\UI\Post\manipulate;

use Nette\SmartObject;
use Nette\Application\UI\Form;
use App\UI\Model\PostFacade;
use Nette\Security\User;

class FormFactory
{
    use SmartObject;

    private array $entity;

    public function __construct(
        private PostFacade $manager,
        private \App\Core\FormFactory $formFactory,
        private User $user,
    ) { }

    public function create(array $entity): Form
    {
        $form = $this->formFactory->create();
        $this -> entity = $entity;

        $form->addHidden('id')
        ->setDefaultValue($entity['id'] ?? null);
        $form->addText('title', 'Titulek:')
            ->setRequired('Zadejte titulek příspěvku.');
        $form->addTextArea('content', 'Obsah:')
            ->setRequired('Zadejte obsah příspěvku.');
        $form->addSubmit('send', 'Odeslat');

        $form->setDefaults($entity);
       
        
        return $form;
    }
    public function onSuccess(Form $form, array $values)
    {   
        $entityId= $this->entity['id'];

        if ($entityId) {
            $this->manager->update($entityId, $values);
        } else {
            unset($values['id']);
            $values['author_id'] = $this->user->id;
            $entityId = $this->manager->insert($values)->id;
        }
        $form['id']->setValue($entityId);
    }
}