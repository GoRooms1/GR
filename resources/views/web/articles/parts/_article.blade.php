<div class="col-md-6 card-wrapper">
    <a href="{{ route('articles.show', $article) }}" class="blog-card">
        <div class="blog-card-img-wrapper" style="background-image: url('{{ asset($article->image->path) }}?w=185&h=185&fit=crop')">
            <div class="blog-card-date">
                <span>{{ $article->created_at->format('d') }}</span>
                <span>{{ $article->getCreateMonthName() }}</span>
            </div>
        </div>
        <div class="blog-card-content">
            <p class="blog-card-title">{{ $article->title }}</p>
            <p class="blog-card-text">{{ $article->notice }}</p>
            <span class="blog-card-more">Подробнее</span>
        </div>
    </a>
</div>
