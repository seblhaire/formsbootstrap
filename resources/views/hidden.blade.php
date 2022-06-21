<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.hidden');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.hidden'), $data);
if (!isset($data['name']) || strlen($data['name']) == 0){
  $data['name'] = $data['id'];
}
 ?>
{{ Form::hidden($data['name'], $data['value'], array_merge(['id' => $data['id']], $data['attributes'])) }}
