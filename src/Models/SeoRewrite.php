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
}
