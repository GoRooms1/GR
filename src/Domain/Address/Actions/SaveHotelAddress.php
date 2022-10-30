<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Domain\Hotel\Models\Hotel;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(Hotel $hotel, string $address_raw, ?string $comment = null)
 */
final class SaveHotelAddress extends Action
{
    public function handle(Hotel $hotel, string $address_raw, ?string $comment = null): void
    {
        $address = $this->getAddressInfo($address_raw);
        $address['comment'] = empty($comment) ? null : $comment;
        $hotel->address()->delete();
        $hotel->address()->create($address)->save();
        $hotel->save();
    }

    public function getAddressInfo(string $address): array
    {
        /** @var array{data: array{value: string}, value: string} $suggest */
        $suggest = DadataSuggest::suggest('address', ['query' => $address, 'count' => 1]);
        $suggest['data']['value'] = $suggest['value'];

        return Address::getFillableData($suggest['data']);
    }
}
