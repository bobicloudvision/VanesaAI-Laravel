<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.chat';

    public $message = '';

    public function sendMessage(): void
    {
        $this->message = '';
    }
}
