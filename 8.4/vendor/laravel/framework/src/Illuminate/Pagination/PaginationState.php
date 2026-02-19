<?php

namespace Illuminate\Pagination;

class PaginationState
{
    /**
     * Bind the pagination state resolvers using the given application container as a base.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public static function resolveUsing($app)
    {
        \Illuminate\Pagination\Paginator::viewFactoryResolver(fn() => $app['view']);
        \Illuminate\Pagination\Paginator::currentPathResolver(fn() => $app['request']->url());
        \Illuminate\Pagination\Paginator::currentPageResolver(function ($pageName = 'page') use ($app) {
            $page = $app['request']->input($pageName);
            if (filter_var($page, \FILTER_VALIDATE_INT) !== \false && (int) $page >= 1) {
                return (int) $page;
            }
            return 1;
        });
        \Illuminate\Pagination\Paginator::queryStringResolver(fn() => $app['request']->query());
        \Illuminate\Pagination\CursorPaginator::currentCursorResolver(function ($cursorName = 'cursor') use ($app) {
            return \Illuminate\Pagination\Cursor::fromEncoded($app['request']->input($cursorName));
        });
    }
}
