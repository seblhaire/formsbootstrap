<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$data = formsbootstrapUtils::mergeValues(config('formsbootstrap.defaults.submit'), $data);
 ?>
{!! Form::submit(FormsBootstrapUtils::translateOrPrint($data['label']), array_merge(['id' => $data['id'], 'class' => $data['class']], $data['attributes'])) !!}
