<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StaticPage extends Model
{
    /**
     * Get formatted markdown content attribute.
     *
     * @return mixed
     */
    public function getFormattedMarkdownContentAttribute()
    {
        return Cache::remember("static-pages:{$this->slug}", now()->addDays(30), function () {
            return Markdown::convertToHtml($this->content ?? '');
        });
    }
}
