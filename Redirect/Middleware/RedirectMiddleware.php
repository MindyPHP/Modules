<?php

namespace Modules\Redirect\Middleware;

use Mindy\Base\Mindy;
use Modules\Redirect\Models\Redirect;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 14/04/14.04.2014 15:20
 */
class RedirectMiddleware
{
    protected function decode($value)
    {
        $value = preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($value));
        return html_entity_decode($value, null, 'UTF-8');
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);

        $pathInfo = $this->decode($request->getRequestTarget());
        if (!empty($pathInfo)) {
            $pattern = '/' . ltrim($pathInfo, '/');
            $model = Redirect::objects()->get(['from_url' => $pattern]);

            if ($model === null) {
                $pattern = '/' . ltrim(strtok($pathInfo, '?'), '/') . '*';
                $model = Redirect::objects()->get(['from_url' => $pattern]);

                if ($model === null) {
                    return $response;
                } else {
                    return $response
                        ->withStatus($model->status)
                        ->withHeader('Location', $model->to_url);
                }
            } else {
                return $response
                    ->withStatus($model->status)
                    ->withHeader('Location', $model->to_url);
            }
        }

        return $response;
    }
}
