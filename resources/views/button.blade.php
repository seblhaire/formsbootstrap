<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.button');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.button'), $data);
 ?>
{!! Form::button($data['label'], array_merge(['id' => $data['id'], 'class' => $data['class']], $data['attributes'])) !!}
