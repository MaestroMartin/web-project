<?php

declare(strict_types=1);

namespace App\UI\Model;

use Nette\SmartObject;

/**
 * Class SettingManager
 *
 * @package App\UI\Model
 * @property-read string $emailSender
 * @property-read string $emailReciever
 */
class SettingManager extends BaseManager
{
    use SmartObject;

    public function getTableName(): string
    {
        return 'setting';
    }

   
    public function getEmailSender(): string
    {   
        return $this->getAll()->get('EMAIL_SENDER')->value;
    }

   
    public function getEmailReciever(): string
    {
        return $this->getAll()->get('EMAIL_REVIEVER')->value;
    }
}
