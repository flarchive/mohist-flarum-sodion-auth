<?php

use Flarum\Extend;
use Flarum\Frontend\Document;
use Mohist\SodionAuthFlarum\Command\ApiKeyCommand;
use Mohist\SodionAuthFlarum\Controller\Controller;

return [
    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
            $document->head[] = '<!-- SodionAuthFlarum Enabled -->';
        }),
    (new Extend\Routes('api'))
        ->post('/sodionauth', 'sodionauth', Controller::class),
    (new Extend\Csrf())
        ->exemptRoute('sodionauth'),
    (new Extend\Console())
        ->command(ApiKeyCommand::class)
];
