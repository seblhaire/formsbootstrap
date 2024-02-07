<?php

namespace Seblhaire\Formsbootstrap;

use Illuminate\Support\ServiceProvider;

//use \Collective\Html\FormFacade as Form;

/**
 * Provides extension of Laravelcollective forms for bootstrap css styles
 * @method Form::bsOpen(array $data) mandatory ['id']. prints <form> cf config('formsbootstrap')
 * @method Form::bsHidden(string $id, int|string $value, (int|string[] $options)) <input type="hidden">
 * @method Form::bcClose() prints </form>
 * @method Form::bsText(array $data) mandatory ['name', 'labeltext] prints <input type="text"> cf config('formsbootstrap')
 * @method Form::bsTextarea(array $data) mandatory ['name', 'labeltext] prints <textarea> cf config('formsbootstrap')
 * @method Form::bsEmail(array $data) prints <input type="email"> cf config('formsbootstrap')
 * @method Form::bsPassword(array $data) prints<input type="password"> cf config('formsbootstrap')
 * @method Form::bsPasswordWithConfirm(array $data) print complete change password, optional old_password and password show/hide button and assword generate button. cf config('formsbootstrap')
 * @method Form::bsSelect(array $data) mandatory name prints <select><option> cf config('formsbootstrap')
 * @method Form::bsCheckbox(array $data) mandatory ['name', 'values'] prints  <input type="checkbox"> cf config('formsbootstrap')
 * @method Form::bsRadio(array $data) mandatory ['name', 'values'] prints <input type="radio"> cf config('formsbootstrap')
 * @method Form::bsSubmit(array $data) prints <input type="submit"> cf config('formsbootstrap')
 * @method Form::bsButton(array $data) mandatory ['id', 'label'] prints <input type="button"> cf config('formsbootstrap')
 */
class FormsBootstrapServiceProvider extends ServiceProvider {

    /**
     * @return void
     */
    public function boot() {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'formsbootstrap');
        $this->publishes([
            __DIR__ . '/../config' => config_path('vendor/seblhaire'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/seblhaire/formsbootstrap'),
            __DIR__ . '/../resources/js' => resource_path('js/vendor/seblhaire/formsbootstrap'),
            __DIR__ . '/../resources/css' => resource_path('css/vendor/seblhaire/formsbootstrap'),
        ]);
    }

    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/formsbootstrap.php', 'formsbootstrap'
        );
        $this->app->singleton('FormsBootstrapService', function ($app) {
            return new FormsBootstrapService();
        });
    }

    public function provides() {
        return [FormsBootstrapServiceContract::class];
    }
}
