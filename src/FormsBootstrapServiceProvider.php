<?php

namespace Seblhaire\Formsbootstrap;

use Illuminate\Support\ServiceProvider;
use \Collective\Html\FormFacade as Form;

/**
 * Provides extension of Laravelcollective forms for bootstrap css styles
 * @method Form::bsOpen(array $data) mandatory ['id']. prints <form> cf config('formsbootstrap')
 * @method Form::hidden(string $id, int|string $value, (int|string[] $options)) <input type="hidden">
 * @method Forms::bcClose() prints </form>
 * @method Forms::bsText(array $data) mandatory ['name', 'labeltext] prints <input type="text"> cf config('formsbootstrap')
 * @method Forms::bsTextarea(array $data) mandatory ['name', 'labeltext] prints <textarea> cf config('formsbootstrap')
 * @method Forms::bsEmail(array $data) prints <input type="email"> cf config('formsbootstrap')
 * @method Forms::bsPassword(array $data) prints<input type="password"> cf config('formsbootstrap')
 * @method Forms::bsPasswordWithConfirm(array $data) print complete change password, optional old_password and password show/hide button and assword generate button. cf config('formsbootstrap')
 * @method Forms::bsSelect(array $data) mandatory name prints <select><option> cf config('formsbootstrap')
 * @method Forms::bsCheckbox(array $data) mandatory ['name', 'values'] prints  <input type="checkbox"> cf config('formsbootstrap')
 * @method Forms::bsRadio(array $data) mandatory ['name', 'values'] prints <input type="radio"> cf config('formsbootstrap')
 * @method Forms::bsSubmit(array $data) prints <input type="submit"> cf config('formsbootstrap')
 * @method Forms::bsButton(array $data) mandatory ['id', 'label'] prints <input type="button"> cf config('formsbootstrap')
 */
class FormsBootstrapServiceProvider extends ServiceProvider
{

    /**
     * https://laravelcollective.com/docs/5.4/html
     *
     * @return void
     */
    public function boot(){
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'formsbootstrap');
        Form::component('bsOpen', 'formsbootstrap::open', ['data']);
        Form::component('bsText', 'formsbootstrap::text', ['data']);
        Form::component('bsNumber', 'formsbootstrap::number', ['data']);
        Form::component('bsRange', 'formsbootstrap::range', ['data']);
	      Form::component('bsTextarea', 'formsbootstrap::textarea', ['data']);
        Form::component('bsEmail', 'formsbootstrap::email', ['data']);
        Form::component('pass', 'formsbootstrap::pass', ['data']);
        Form::component('bsPassword', 'formsbootstrap::password', ['data']);
        Form::component('bsPasswordWithConfirm', 'formsbootstrap::password-with-confirm', ['data']);
        Form::component('bsSelect', 'formsbootstrap::select', ['data']);
        Form::component('bsCheckbox', 'formsbootstrap::checkbox', ['data']);
        Form::component('bsRadio', 'formsbootstrap::radio', ['data']);
        Form::component('bsSubmit', 'formsbootstrap::submit', ['data']);
        Form::component('bsButton', 'formsbootstrap::button', ['data']);
        Form::component('bsColorpicker', 'formsbootstrap::colorpicker', ['data']);
        Form::component('bsEditor', 'formsbootstrap::editor', ['data']);
        Form::macro('bsClose', function(){
            return '</form>';
        });
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'formsbootstrap');
        $this->publishes([
            __DIR__.'/../config' => config_path('vendor/seblhaire'),
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/seblhaire/formsbootstrap'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/seblhaire/formsbootstrap'),
            __DIR__.'/../resources/js' => resource_path('js/vendor/seblhaire/formsbootstrap'),
            __DIR__.'/../resources/css' => resource_path('css/vendor/seblhaire/formsbootstrap'),
        ]);
    }

    public function register(){
      $this->mergeConfigFrom(
          __DIR__.'/../config/formsbootstrap.php', 'formsbootstrap'
      );
    }

    public function provides(){
        return [];
    }

}
