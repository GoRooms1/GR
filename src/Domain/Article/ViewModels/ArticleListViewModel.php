<?php

declare(strict_types=1);

namespace Domain\Article\ViewModels;

use Domain\Article\DataTransferObjects\ArticleData;
use Domain\Article\Models\Article;
use Domain\Page\DataTransferObjects\PageData;
use Domain\Page\Models\Page;

final class ArticleListViewModel extends \Parent\ViewModels\ViewModel
{    
    /**     
     * @return PageData
     */
    public function page(): ?PageData
    {        
        $page = Page::whereSlug('blog')->firstOrFail();

        return $page->load('meta', 'images')->getData();       
    }

    public function articles()
    {
        return fn() => ArticleData::collection(Article::orderBy('created_at', 'DESC')->paginate(1));
    }
}
