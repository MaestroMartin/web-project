<?php

declare (strict_types=1);

namespace App\UI\Model;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\Template;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Tracy\Debugger;
use Nette\Application\UI\TemplateFactory;



class MailSender 
{
    

    public function __construct(
        private TemplateFactory $templateFactory,
        private LinkGenerator $linkGenerator,
        private  SettingManager  $settingManager,
        private string $lattePath,
       
    )
    { }
      

    private function createMessage(): Message
    {
        $message= new Message();

        $message->setFrom($this->settingManager->emailSender);
        $message->addTo($this->settingManager->emailReciever);
        return $message;
    }

    private function send(Message $message):void
    {   if (Debugger::$productionMode){
        return;
    }
        $sender =  new SendmailMailer();
        $sender->send($message);
    }

    private function createLatteTemplate():Template
    {
        $latte = $this->templateFactory->createTemplate();
        $this->$latte->getLatte()->addProvider('uiControl', $this->linkGenerator);

        return $latte;
    }

    public function sendPostInserted(array $values)
    {
        $message = $this->createMessage();
        

        ob_start();
        $template = $this->createLatteTemplate();
        $template->setFile($this->lattePath . 'addPostMail.latte');
        foreach ($values as $key => $value) {
            $template->$key = $value;
        }
        $template->render();
        $htmlBody = ob_get_clean();
        $message->setHtmlBody($htmlBody);

        $this->send($message);
    }


}