<?php

declare(strict_types=1);

namespace Domain\AdBanner\DataTransferObjects;

use DateTime;
use Domain\AdBanner\Models\AdBanner;
use Domain\Media\DataTransferObjects\MediaImageData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class AdBannerData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $url,
        public ?string $email,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class,  format: 'Y-m-d')]  
        public ?DateTime $show_from,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class,  format: 'Y-m-d')]        
        public ?DateTime $show_to,        
        public bool $is_show_always,
        public bool $is_show_on_hotels,
        public bool $is_show_on_rooms,
        public bool $is_show_on_hotel,
        public bool $is_show_on_hot,        
        public array|null $cities,
        public ?Carbon $created_at,        
        public ?Carbon $updated_at,
        #[DataCollectionOf(MediaImageData::class)]     
        public null|Lazy|DataCollection $images,
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        return self::from([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'email' => $request->get('email'),
            'show_from' => $request->get('show_from') ? Carbon::createFromFormat('Y-m-d', $request->get('show_from')) : null,
            'show_to' => $request->get('show_to') ? Carbon::createFromFormat('Y-m-d', $request->get('show_to')) : null,
            'is_show_always' => $request->boolean('is_show_always'),
            'is_show_on_hotels' => $request->boolean('is_show_on_hotels'),
            'is_show_on_rooms' => $request->boolean('is_show_on_rooms'),
            'is_show_on_hotel' => $request->boolean('is_show_on_hotel'),
            'is_show_on_hot' => $request->boolean('is_show_on_hot'),
            'cities' => $request->get('cities'),
        ]);
    }

    public static function fromModel(AdBanner $adBanner): self
    {
        return self::from([
           ...$adBanner->toArray(),
           'images' => MediaImageData::collection($adBanner->getMedia('images')),
        ]);
    }
}
