<?php

namespace App\Http\Middleware;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Closure;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Litlife\Url\Url;

class SEOMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $description = "ABA Expert — реестр специалистов и центров, предлагающий актуальную информацию о профессионалах в области ABA.
        На сайте вы найдете доску объявлений, полезные вебинары, обширную библиотеку и информацию о предстоящих мероприятиях.";

        SEOMeta::setDescription($description);
        SEOMeta::addKeyword(implode(', ', [
            'ABA специалисты', 'ABA центры', 'ABA доска объявлений', 'ABA материалы', 'ABA вебинары', 'ABA мероприятия'
        ]));

        $url = Url::fromString($request->fullUrl());

        $page = intval($url->getQueryParameter('page'));

        if ($page < 2) {
            $url = (string)$url->withoutQueryParameter('page');
        } elseif ($page > 1) {
            $url = (string)$url->withQueryParameter('page', $page);
        } else {
            $url = (string)$url;
        }

        $title = ltrim(Breadcrumbs::pageTitle(), '');
        $image = Vite::asset('resources/images/logo_236.png');

        OpenGraph::addProperty('url', $url);
        OpenGraph::setTitle($title);
        OpenGraph::setType('website');
        OpenGraph::addImage($image);

        TwitterCard::setUrl($url);
        SEOMeta::setCanonical($url);

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('Article');
        JsonLd::addImage($image);

        return $next($request);
    }
}
