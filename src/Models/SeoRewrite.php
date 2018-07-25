<?php
namespace BlackBits\LaravelSeoRewrite\Models;

use BlackBits\LaravelSeoRewrite\Events\SavingSeoRewriteEvent;
use Illuminate\Database\Eloquent\Model;

class SeoRewrite extends Model
{
    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'saving' => SavingSeoRewriteEvent::class,
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model) {
            $model->source = "/" . ltrim($model->source, '/');
        });

    }
}
