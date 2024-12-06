<?php

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler as Handlers;

class WebhookHandler extends Handlers
{
    public function start(): void
    {
        $this->reply('Hello world!');
    }

    public function help(): void
    {
        $this->reply('Help!');
    }
    public function menu(): void
    {
        $this->reply('This is the menu!');
    }
}
