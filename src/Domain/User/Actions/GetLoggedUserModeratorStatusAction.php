<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use App\User;
use Auth;
use Parent\Actions\Action;

/**
 * @method static bool run()
 */
final class GetLoggedUserModeratorStatusAction extends Action
{
    /**     
     * @return bool
     */
    public function handle(): bool
    {
        if (Auth::check()) {
            $user = User::find(auth()->id());

            if ($user->is_admin || $user->is_moderate) 
                return true;
        }

        return false;
    }
}
