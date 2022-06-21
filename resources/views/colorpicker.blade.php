<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$mandatory = config('formsbootstrap.mandatory.colorpicker');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.colorpicker'), $data);
if (!isset($data['name']) || strlen($data['name']) == 0){
  $data['name'] = $data['id']. '-input';
}
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
@endif
{{ Form::label($data['id'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
<input type="color" class="{{ $data['inputclass'] }}" id="{{ $data['id'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['title']) }}">
@if ($data['input_in_div'])
</div>
@endif
