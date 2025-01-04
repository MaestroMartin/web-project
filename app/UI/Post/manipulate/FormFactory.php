<?php

declare(strict_types=1);

namespace App\UI\Post\manipulate;

use Nette\SmartObject;
use Nette\Application\UI\Form;
use App\UI\Model\PostFacade;

class FormFactory
{
    use SmartObject;

    private array $entity;

    public function __construct(
        private PostFacade $manager,
    ) { }

    public function create(array $entity): Form
    {
        $form = new Form();

        $this -> entity = $entity;

        $form->addHidden('id');
        $form->addText('title', 'Titulek:')
            ->setRequired('Zadejte titulek příspěvku.');
        $form->addTextArea('content', 'Obsah:')
            ->setRequired('Zadejte obsah příspěvku.');
        $form->addSubmit('send', 'Odeslat');

        
        $form->setDefaults($entity);
        
        return $form;
    }
    public function onSuccess(Form $form, array $values): void
    {   
        $entityId= $values['id'];

        if ($this->entityId) {
            $this->manager->update($this->entityId,$values);
        } else {
            unset($values['id']);
            $entityId = $this->postFacade->insert($values)->id;
        }
        $form['id']->setValue($this->entityId);
    }
}