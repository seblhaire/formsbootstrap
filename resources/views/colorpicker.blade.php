<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$mandatory = config('formsbootstrap.mandatory.colorpicker');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.colorpicker'), $data);
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
@endif
{{ Form::label($data['name'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
<input type="color" class="{{ $data['inputclass'] }}" id="{{ $data['name'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['title']) }}">
@if ($data['input_in_div'])
</div>
@endif
