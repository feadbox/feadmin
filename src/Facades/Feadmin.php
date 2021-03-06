<?php

namespace Feadmin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Feadmin\Hooks\Panel create(string $panel)
 * @method static \Feadmin\Hooks\Panel find(string $panel)
 * @method static array panels()
 * @method static \Feadmin\Hooks\Panel getCurrentPanel()
 * @method static void setCurrentPanel(string $panel)
 * @method static \Feadmin\Hooks\Panel getExtensionPanel()
 * @method static void setExtensionPanel(string $panel)
 * @method static void usePanelRoutes()
 * @method static void useExtensionRoutes()
 * @method static void useWebRoutes()
 * @method static void useRoutes()
 * @method static string version()
 * 
 * @see \Feadmin\Feadmin
 */
class Feadmin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Feadmin\Feadmin::class;
    }
}
