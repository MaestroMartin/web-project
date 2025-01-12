<?php

declare(strict_types=1);


namespace App\UI\User\Sign\In;

use App\Core\FormFactory as CoreFormFactory;
use Exception;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use stdClass;
use Nette\security\User;

class FormFactory
{   
    use SmartObject;

    public function __construct(
        private User $user,
        private CoreFormFactory $formFactory,
        private \App\UI\User\Sign\In\ControlFactory $signInFormFactory
    ){}

    public function create(): Form{
        
        $form = $this->formFactory->create();

        $form->getElementPrototype()->setAttribute('novalidate','novalidate');

        $form->addEmail('email', 'Váš E-mail:')
            ->setRequired('Prosím vyplňte svůj E-mail:.');
        
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím vyplňte své heslo.');
        
        $form->addSubmit('send', 'Přihlásit');
        
        $form->onSuccess[] = [$this, 'onSuccess'];
        return $form;
    }

    

    public function onSuccess(Form $form, stdClass $values): void
    {
        try {
            $this->user->login($values->email, $values->password);
        } catch (Exception $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }
}