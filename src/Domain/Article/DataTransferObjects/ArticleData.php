<?php

declare(strict_types=1);

namespace Domain\Article\DataTransferObjects;

use Carbon\Carbon;
use Domain\Article\Models\Article;
use Domain\Media\DataTransferObjects\MediaImageData;

final class ArticleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?string $title,
        public ?string $notice,
        public ?string $content,
        public ?string $slug,
        public string $meta_title,
        public ?string $meta_description,
        public ?string $meta_keywords,
        public ?int $user_id,
        public ?Carbon $deleted_at,        
        public ?Carbon $updated_at,
        public ?Carbon $created_at,
        public ?MediaImageData $image,
        public readonly string $day,
        public readonly string $month,
    ) {
    }

    public static function fromModel(Article $article): self
    {
        return self::from([
            ...$article->toArray(), 
            'meta_title' => $article->meta_title ?? $article->title,
            'day' => $article->created_at->format('d'),
            'month' => $article->getCreateMonthName(),        
            'image' => $article->getFirstMedia('images') ? MediaImageData::fromModel($article->getFirstMedia('images')) : null,            
        ]);
    }
}
