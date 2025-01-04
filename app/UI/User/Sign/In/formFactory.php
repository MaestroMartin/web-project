<?php

declare(strict_types=1);


namespace App\UI\User\Sign\In;

use Exception;
use Nette\Application\UI\Form;
use Nette\Database\Explorer;
use stdClass;
use Nette\security\User;

class FormFactory
{
    public function __construct(
        private User $user,

    )
    {
    }

    public function create(): Form{
        $form = new Form;
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
            $this->user->login($values->username, $values->password);
        } catch (Exception $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }
}