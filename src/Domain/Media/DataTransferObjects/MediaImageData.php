<?php

declare(strict_types=1);

namespace Domain\Media\DataTransferObjects;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaImageData extends \Parent\DataTransferObjects\Data
{
    
    public function __construct( 
        public ?int $id,
        public ?string $name,     
        public string $url,        
        public ?int $order,
        public Bool $moderate, 
        public Collection|null $conversions,      
    ) {
    }

    public static function fromModel(Media $media): self
    {      
        return self::from([
            'id' => $media->id,
            'name' => $media->name,
            'url' => $media->getUrl(),          
            'order' => $media->order_column,
            'moderate' => $media->getCustomProperty("moderate"),
            'conversions' => $media->getGeneratedConversions()->map(fn ($el, $key) => $el = $media->getUrl($key)),
        ]);
    }
}
