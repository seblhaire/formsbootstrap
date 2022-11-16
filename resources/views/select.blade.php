<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.select');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(array_merge(config('formsbootstrap.defaults.select'), config('formsbootstrap.classes')), $data);
if ($data['required']){
  $data['inputclass'] .= ' ' . $data['requiredclass'];
}
$data['inputclass'] .= ' ' . $data['resetselectclass'];
if ($data['multiple']){
  if (preg_match('/^(\w+)\[\]$/', $data['name'], $m) > 0){
    $data['id'] = $m[1];
    $data['attributes'] = array_merge(['multiple' => 'multiple', 'id' => $data['id']], $data['attributes']);
  }else{
    $data['id'] = $data['name'];
    $data['attributes'] = array_merge(['multiple' => 'multiple', 'id' => $data['id']], $data['attributes']);
    $data['name'] .= '[]';
  }
}else{
  $data['id'] = $data['name'];
}
$data['default'] = explode(',', $data['default']);
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['id'] }}">
@endif
{{ Form::label($data['id'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
<select id="{!! $data['id'] !!}" name="{!! $data['name'] !!}" class="{!! $data['inputclass'] !!}"@foreach($data['attributes'] as $attrkey => $attrvalue) {!! $attrkey !!}="{{ $attrvalue }}"@endforeach>@foreach($data['values'] as $valkey => $value)<option value="{!! $valkey !!}"@if(in_array($valkey, $data['default'])) defaultchecked="defaultchecked" selected="selected"@endif>{{ $value }}</option>@endforeach</select>
@if ($data['feedback'] &&  strlen($data['valid-feedback']) > 0)
<div class="valid-feedback">{{ $data['valid-feedback'] }}</div>
@endif
@if ($data['feedback'] &&  strlen($data['invalid-feedback']) > 0)
<div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
@endif
@if (strlen($data['helptext']) > 0)
<p class="help-block">{{ $data['helptext'] }}</p>
@endif
@if ($data['input_in_div'])
</div>
@endif
