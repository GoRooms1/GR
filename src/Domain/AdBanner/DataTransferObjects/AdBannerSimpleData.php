<?php

declare(strict_types=1);

namespace Domain\AdBanner\DataTransferObjects;

use Domain\AdBanner\Models\AdBanner;
use Domain\Media\DataTransferObjects\MediaImageData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class AdBannerSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,        
        public ?string $url,       
        #[DataCollectionOf(MediaImageData::class)]     
        public null|Lazy|DataCollection $images,
    ) {
    }
    public static function fromModel(AdBanner $adBanner): self
    {
        return self::from([
            'id' => $adBanner->id,
            'url' => $adBanner->url, 
            'images' => MediaImageData::collection($adBanner->getMedia('images')),
        ]);
    }
}
