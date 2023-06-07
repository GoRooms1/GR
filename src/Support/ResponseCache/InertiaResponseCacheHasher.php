<?php

namespace Support\ResponseCache;

use Illuminate\Http\Request;
use Spatie\ResponseCache\Hasher\DefaultHasher;

class InertiaResponseCacheHasher extends DefaultHasher
{
    public function getHashFor(Request $request): string
    {
        $baseHash = parent::getHashFor($request);

        $contentType = $request->getContentType();

        return "{$baseHash}-{$contentType}";
    }
}