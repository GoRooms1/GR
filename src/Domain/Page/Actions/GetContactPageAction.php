<?php

namespace Domain\Page\Actions;

use Domain\Page\Models\Page;
use Parent\Actions\Action;

/**
 * @static @method Page run()
 */
final class GetContactPageAction extends Action
{
    public function handle(): Page
    {
        return Page::whereSlug('contacts')->firstOrFail();
    }
}
