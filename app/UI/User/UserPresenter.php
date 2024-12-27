<?php

namespace App\UI\User;

use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use Nette\Security\User as NetteUser;
use Nette\Database\Explorer;


class UserPresenter extends Presenter
{
    private NetteUser $user;
    private Explorer $database;
    

    public function __construct(NetteUser $user, Explorer $database)
    {
        $this->user = $user;
        $this->database = $database;
    }

    public function beforeRender(): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    public function renderDefault(): void
{
    $identity = $this->user->getIdentity();
    $identity->username = $identity->id; // Přidáme uživatelské jméno jako atribut

    $this->template->users = $this->database->table('users');
    $this->template->loggedInUser = $identity;
}


    public function actionEdit(string $username): void
    {
    $loggedInUsername = $this->user->getIdentity()->username; // Získání uživatelského jména přihlášeného uživatele

    if ($username !== $loggedInUsername) {
        $this->flashMessage('Nemáte oprávnění upravovat tyto údaje.', 'error');
        $this->redirect('User:default');
    }

    $user = $this->database->table('users')->where('username', $username)->fetch();

    if (!$user) {
        $this->flashMessage('Uživatel nebyl nalezen.', 'error');
        $this->redirect('User:default');
    }

    $this["editForm"]->setDefaults($user->toArray());
    }


    protected function createComponentEditForm(): Form
    {
        $form = new Form;
        $form->addText('username', 'Uživatelské jméno:')
            // Uživatel nemůže změnit své uživatelské jméno
            ->setRequired('Vyplňte své uživatelské jméno.');

        $form->addText('email', 'E-mail:')
            ->setRequired('Vyplňte svůj e-mail.');
            

        $form->addPassword('password', 'Nové heslo:')
            ->setRequired(false)
            ->setNullable();

        $form->addSubmit('send', 'Uložit změny');

        $form->onSuccess[] = [$this, 'editFormSucceeded'];

        return $form;
    }

    public function editFormSucceeded(Form $form, array $values): void
    {
    $username = $this->user->getIdentity()->username;
    $user = $this->database->table('users')->where('username', $username)->fetch();

    if (!$user) {
        $this->flashMessage('Uživatel nebyl nalezen.', 'error');
        $this->redirect('User:default');
    }

    $updateData = [
        'email' => $values['email'],
    ];

    if (!empty($values['password'])) {
        $updateData['password'] = $values['password']; // Zde doporučuji hashovat heslo
    }

    $user->update($updateData);
    $this->flashMessage('Údaje byly úspěšně aktualizovány.', 'success');
    $this->redirect('default');
    }

}
