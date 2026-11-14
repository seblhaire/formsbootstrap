<?php
namespace Seblhaire\Formsbootstrap\Facades;
use Illuminate\Support\Facades\Facade;
/**
 * Description of FormFacade
 *
 * @author seb
 */
class FormFacade extends Facade {
    /**
     * Builds a facade
     *
     * @return [type] [description]
     */
    protected static function getFacadeAccessor()
    {
        return 'FormsBootstrapService';
    }
}
