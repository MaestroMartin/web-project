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

    public function beforeRender()
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    public function renderDefault(): void
    {
        $this->template->users = $this->database->table('users');
    }

    public function actionEdit(int $id): void
    {
        if (!$this->user->isLoggedIn() || $this->user->getId() !== $id) {
            $this->error('Nemáte oprávnění upravovat tohoto uživatele.');
        }

        $user = $this->database->table('users')->get($id);
        if (!$user) {
            $this->error('Uživatel nebyl nalezen.');
        }

        $this['editForm']->setDefaults($user->toArray());
    }

    protected function createComponentEditForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Username:')
            ->setRequired('Zadejte své jméno.');
        $form->addText('email', 'Email:')
            ->setRequired('Zadejte svůj email.');

        $form->addSubmit('save', 'Uložit změny');

        $form->onSuccess[] = [$this, 'editFormSucceeded'];

        return $form;
    }

    public function editFormSucceeded(Form $form, \stdClass $values): void
    {
        $id = $this->getParameter('id');
        $user = $this->database->table('users')->get($id);

        if (!$user) {
            $this->error('Uživatel nebyl nalezen.');
        }

        $user->update([
            'name' => $values->username,
            'email' => $values->email,
        ]);

        $this->flashMessage('Vaše údaje byly úspěšně aktualizovány.', 'success');
        $this->redirect('Users:Userdefault');
    }
}
