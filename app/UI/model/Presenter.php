<?php

declare(strict_types=1);

namespace App\UI\Model;

use Nette\Application\UI\Presenter as UIPresenter;
use App\UI\Model\Entity\Resource;
use Nette\Application\Attributes\Persistent;
use Nette\DI\Attributes\Inject;
use Nette\Localization\Translator;
use App\UI\Model\MyTranslator;

class Presenter extends UIPresenter
{
    #[Persistent]
    public string $lang = 'cs'; // Výchozí jazyk

    #[Inject]
    public  Translator $translator; // readonly property pro neměnnost po inicializaci

    public function startup(): void
    {
        parent::startup();

        // Ověř, zda $translator je instance MyTranslator
        if ($this->translator instanceof MyTranslator) {
            // Nastav jazyk pomocí setLang
            $this->translator->setLang($this->lang ?? 'cs');
        }
    }

    public function setLang(string $lang): void
    {
    $this->lang = $lang;
    }


    /**
     * Zkontroluje oprávnění uživatele k určitému zdroji a akci.
     * 
     * @param string|Resource $resource Zdroj, ke kterému se přistupuje (např. "post").
     * @param string $privilege Akce, kterou chce uživatel provést.
     */
    protected function checkPrivilage(string|Resource $resource = 'post', string $privilege): void
    {
        if (!$this->getUser()->isAllowed($resource, $privilege)) {
            $this->flashMessage('Pro tuto akci je nutné se přihlásit.', 'error');
            $this->redirect('Sign:in', $this->storeRequest());
        }
    }
}
