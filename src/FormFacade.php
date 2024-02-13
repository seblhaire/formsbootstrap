<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Seblhaire\Formsbootstrap;
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
