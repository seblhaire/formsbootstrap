<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.text');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(array_merge(config('formsbootstrap.defaults.text'), config('formsbootstrap.classes')), $data);
if ($data['required']){
  $data['inputclass'] .= ' ' . $data['requiredclass'];;
}
$data['inputclass'] .= ' ' . $data['resettextclass'];
if (!isset($data['name']) || strlen($data['name']) == 0){
  $data['name'] = $data['id']. '-input';
}
 ?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
@endif
{{ Form::label($data['id'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
{{ Form::text($data['name'], $data['value'], array_merge(['id' => $data['id'], 'class' => $data['inputclass']], $data['attributes'])) }}
@if (strlen($data['valid-feedback']) > 0)
<div class="valid-feedback">{{ $data['valid-feedback'] }}</div>
@endif
@if ($data['required'] && strlen($data['invalid-feedback']) > 0)
<div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
@endif
@if (strlen($data['helptext']) > 0)
<p class="help-block">{{ $data['helptext'] }}</p>
@endif
@if ($data['input_in_div'])
</div>
@endif
