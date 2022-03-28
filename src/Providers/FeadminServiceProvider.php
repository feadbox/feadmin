<?php

namespace Feadmin\Providers;

use Feadmin\Facades\Localization;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined;

class FeadminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootPublishes();

            return;
        }

        $this->bootViews();
        $this->bootLocalization();
        $this->bootGates();
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(dirname(__DIR__) . '/../resources/views', 'feadmin');
    }

    private function bootLocalization(): void
    {
        Blade::directive('t', function ($expression) {
            return "<?php echo t({$expression}) ?>";
        });

        $this->app->setLocale(Localization::getCurrentLocale()->code);

        $allLocales = Localization::getAllLocales();
        $availableLocaleCodes = Localization::getAvailableLocales()->pluck('code')->toArray();
        $supportedLocales = $allLocales->whereIn('code', $availableLocaleCodes)->toArray();

        if (count($supportedLocales) <= 0) {
            throw new SupportedLocalesNotDefined('No supported locales found.');
        }

        config([
            'translatable.locales' => $availableLocaleCodes,
            'laravellocalization.supportedLocales' => $supportedLocales,
        ]);

        Localization::group('panel', [
            'title' => t('Panel', 'panel'),
            'description' => t('Paneldeki metinleri çevirin.', 'panel'),
        ]);

        Localization::group('routes', [
            'title' => t('Sayfa adresleri', 'admin'),
            'description' => t('Sitedeki tüm modüllerin bağlantı yapılarını çevirin', 'admin')
        ]);
    }

    private function bootGates(): void
    {
        Gate::before(function ($user) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    private function bootPublishes(): void
    {
        $this->publishes([
            dirname(__DIR__) . '/../resources/views' => resource_path('views/vendor/feadmin'),
        ], ['feadmin-views', 'views']);

        $this->publishes([
            dirname(__DIR__) . '/../public' => public_path('vendor/feadmin'),
        ], ['feadmin-public', 'public']);

        $this->publishes([
            dirname(__DIR__) . '/../database/migrations' => database_path('migrations'),
        ], ['feadmin-migrations', 'migrations']);
    }
}
