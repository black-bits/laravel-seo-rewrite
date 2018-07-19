<?php
namespace BlackBits\LaravelSeoRewrite\Middleware;

use BlackBits\LaravelSeoRewrite\Models\SeoRewrite;
use Closure;

class LaravelSeoRewrites
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $seoRewrite = SeoRewrite::whereSource('/' . $request->path())->first();

        if ($seoRewrite)
            return response()->redirectTo($seoRewrite->destination, $seoRewrite->type);

        return $next($request);
    }
}