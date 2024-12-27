<?php

namespace App\UI\Sign;

use ErrorException;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use Nette\Database\Explorer;
use Nette\Security\Role;
use Nette\Security\Authenticator;

class SignPresenter extends Presenter
{
    private string $storeRequestId = '';
    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    public function actionIn(string $storeRequestId = '')
    {
        $this->storeRequestId = $storeRequestId;
    }

    public function actionOut()
    {
        $this->user->logout(true);
        $this->flashMessage('Odhlášení proběhlo úspěšně', 'success');
        $this->redirect('Home:');
    }

    protected function createComponentSignInForm(): Form
    {
        $form = new Form;
        $form->addText('username', 'Uživatelské jméno:')
            ->setRequired('Prosím vyplňte své uživatelské jméno.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím vyplňte své heslo.');

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            // Načtení uživatele z databáze
            $user = $this->database->table('users')
                ->where('username', $values->username)
                ->fetch();
    
            if (!$user) {
                throw new ErrorException('Uživatel nebyl nalezen.');
            }
    
            if ($user->password !== $values->password) {
                throw new ErrorException('Nesprávné heslo.');
            }
    
            // Přihlášení uživatele pouze na základě ID nebo username
            $this->user->setAuthenticator(new \Nette\Security\SimpleAuthenticator([
                $values->username => $values->password
            ]));
            $this->user->login($values->username, $values->password);
    
            $this->flashMessage('Úspěšně přihlášeno.', 'success');
            $this->restoreRequest($this->storeRequestId);
            $this->redirect('Home:');
        } catch (ErrorException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }
    
}
