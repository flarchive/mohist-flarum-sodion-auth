<?php

use Flarum\Extend;
use Flarum\Frontend\Document;
use Mohist\SodionAuthFlarum\Controller\Controller;

return [
    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
            $document->head[] = '<!—- SodionAuthFlarum —->';
        }),
    (new Extend\Routes('api'))
        ->post('/sodionAuth', 'sodionAuth', Controller::class),
    (new Extend\Csrf())
        ->exemptPath('/api/sodionAuth')
];
