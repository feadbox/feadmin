<?php

namespace Feadmin\Models;

use Feadmin\Eloquent\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Preference extends Model implements HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia;

    protected $fillable = [
        'namespace',
        'bag',
        'key',
    ];

    public $translatedAttributes = [
        'value',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('lg')->width(1920)->height(1080);
        $this->addMediaConversion('sm')->width(400)->height(225);
    }
}
