<?php

declare(strict_types=1);

namespace Domain\Settings\Actions;

use Cache;
use Domain\Settings\Models\Settings;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetContactsSettingsAction extends Action
{
    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        $data = Cache::store('redis')->rememberForever('contacts', function (): Collection {
            /** @var Collection */
            return Settings::whereIn('option', [
                'notify',
                'instagram',
                'fb',
                'vk',
                'youtube',
                'phone',
                'phone2',
                'telegram',
                'address',
                'org_name',
                'ogrn',
                'inn',
                'kpp',
                'bank_name',
                'bank_acc',
                'bank_сorr_acc',
                'bank_bik',
                'bank_inn',
                'bank_kpp',
                'zen',
            ])->pluck('value', 'option');
        });

        /** @var Collection */
        return $data;
    }
}
