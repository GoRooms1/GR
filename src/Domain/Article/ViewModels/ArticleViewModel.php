<?php

declare(strict_types=1);

namespace Domain\Article\ViewModels;

use Domain\Article\DataTransferObjects\ArticleData;
use Domain\Article\Models\Article;

final class ArticleViewModel extends \Parent\ViewModels\ViewModel
{    
    
    public function __construct(
        protected Article $article,
    ) {
    }
    public function article()
    {
        return ArticleData::fromModel($this->article);
    }
}
