<?='<?xml version="1.0" encoding="UTF-8"?>'?>
@php($added = [])
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($links AS $link)
    <url>
        <loc>{{ $link->loc }}</loc>
        <lastmod>{{ $link->lastmod }}</lastmod>
        <changefreq>{{ $link->changefreq }}</changefreq>
        <priority>{{ $link->priority }}</priority>
    </url>
@endforeach
</urlset>
