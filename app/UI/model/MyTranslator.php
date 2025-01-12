<?php

declare(strict_types=1);

namespace App\UI\Model;

use Nette\Localization\Translator;

class MyTranslator implements Translator
{
    private string $lang;
    private string $defaultLang;
    /**
     * 
     * @inheritDoc
     * 
     */

    public function __construct(
       string $defaultLang = 'cs'
    )
    {
        $this->defaultLang = $defaultLang;
        $this->lang = $defaultLang;
    } 

    public function setLang($lang)
    {
        $this->lang= $lang;
    }


    public array $translationMapper = ['hello_world'=>['cs' => 'ahoj světe', 'en '=> 'Hello world']];

    public function translate($message, mixed ...$parameters): string
    {
        // Zjisti překlad zprávy
        $translations = $this->translationMapper[$message] ?? null;

        // Pokud zpráva není v mapě, vrátí původní text
        if (!is_array($translations)) {
            return $message;
        }

        // Urči jazyk – přednost má parametr 'lang', jinak použij aktuální jazyk
        $lang = $parameters['lang'] ?? $this->lang;

        // Pokud překlad pro daný jazyk existuje, vrať jej, jinak vrať původní zprávu
        return $translations[$lang] ?? $message;
    }
}