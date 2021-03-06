<?php

use Feadmin\Facades\Feadmin;
use Feadmin\Facades\Preference;
use Feadmin\Hooks\Panel;
use Illuminate\Http\RedirectResponse;

function panel(string $panel = null): ?Panel
{
    if (is_null($panel)) {
        return Feadmin::getCurrentPanel();
    }

    return Feadmin::find($panel);
}

function preference(string|array $rawKey, mixed $default = null): mixed
{
    if (is_array($rawKey)) {
        return Preference::set($rawKey);
    }

    return Preference::get($rawKey, $default);
}

function panel_route($name, $parameters = [], $absolute = true): string
{
    return panel()->route($name, $parameters, $absolute);
}

function to_panel_route($route, $parameters = [], $status = 302, $headers = []): RedirectResponse
{
    return panel()->toRoute($route, $parameters, $status, $headers);
}

function ext_asset(string $raw): string
{
    [$extension, $asset] = explode('::', $raw);

    return route('ext-asset', [$extension, $asset]);
}
