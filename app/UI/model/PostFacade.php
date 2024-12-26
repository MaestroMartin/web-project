<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Application\UI\TemplateFactory;
use Nette\Application\LinkGenerator;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use Tracy\Debugger;

class PostFacade
{
    use SmartObject;

    private TemplateFactory $templateFactory;
    private LinkGenerator $linkGenerator;

    public function __construct(
        private Explorer $db,
        TemplateFactory $templateFactory,
        LinkGenerator $linkGenerator,
        // <-- nový parametr pro jméno autora z konfigurace
    ) {
        $this->templateFactory = $templateFactory;
        $this->linkGenerator = $linkGenerator;
    }

    public function getAll(): Selection
    {
        return $this->db->table('post');
    }

    public function getById(int $id): ?ActiveRow
    {
        return $this->getAll()->get($id);
    }

    public function insert(array $values): ActiveRow
    {
        // Uložíme jméno autora z configu, pokud není ve $values explicitně uvedeno
        if (!isset($values['author_name'])) {
            $values['author_name'] = 'anonymous';
        }

        $retVal = $this->getAll()->insert($values);

        /* Mail send START (beze změny)
        if (Debugger::$productionMode) {
            $latte = $this->templateFactory->createTemplate();
            $latte->getLatte()->addProvider('uiControl', $this->linkGenerator);

            $message = new Message();
            $message->setFrom('default@news.cz');
            $message->addTo('default@news.cz');

            $message->setHtmlBody(
                $latte->renderToString(__DIR__ . '/addPostMail.latte', $retVal->toArray())
            );

            $sender = new SendmailMailer();
            $sender->send($message);
        }
        // Mail send END */

        return $retVal; 
    }

    public function getPublicPosts(int $limit = null): Selection
    {
        $retVal = $this->getAll()
            ->where('created_at < ', new DateTime)
            ->order('created_at DESC');

        if ($limit) {
            $retVal->limit($limit);
        }

        return $retVal;
    }
}
