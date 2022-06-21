<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.range');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(array_merge(config('formsbootstrap.defaults.range'), config('formsbootstrap.classes')), $data);
if (!is_null($data['value'])){
  $data['placeholder'] = $data['value'];
}
$data['inputclass'] .= ' ' . $data['resettextclass'];
if (!isset($data['name']) || strlen($data['name']) == 0){
  $data['name'] = $data['id']. '-input';
}
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['id'] }}">
@endif
{{ Form::label($data['id'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
@if ($data['showvalue'] || $data['show_bounds'])
<div class="{{ $data['groupclass'] }}">
  @if (!is_null($data['min']) && $data['show_bounds'])
  <span class="{{ $data['groupeltclass'] }}">{{ $data['min'] }}</span>
  @endif
  <input type="range" class="{{ $data['inputclass'] }}" id="{{ $data['id'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}"
    @if (!is_null($data['min']))
      min="{{ $data['min'] }}"
    @endif
    @if (!is_null($data['max']))
      max="{{ $data['max'] }}"
    @endif
    @if (!is_null($data['step']))
      step="{{ $data['step'] }}"
    @endif
    @if (isset($data['placeholder']) && !is_null($data['placeholder']))
      placeholder="{{ $data['placeholder'] }}"
    @endif
  >
  @if (!is_null($data['max']) && $data['show_bounds'])
  <span class="{{ $data['groupeltclass'] }}">{{ $data['max'] }}</span>
  @endif
  @if ($data['showvalue'])
  <span class="{{ $data['groupeltresclass'] }}">
    {{ FormsBootstrapUtils::translateOrPrint($data['valueprefix']) }}:&nbsp;<span id="{{ $data['id'] }}_val"></span>
  </span>
  @endif
</div>
@else
<input type="range" class="{{ $data['inputclass'] }}" id="{{ $data['id'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}"
  @if (!is_null($data['min']))
    min="{{ $data['min'] }}"
  @endif
  @if (!is_null($data['max']))
    max="{{ $data['max'] }}"
  @endif
  @if (!is_null($data['step']))
    step="{{ $data['step'] }}"
  @endif
  @if (isset($data['placeholder']) && !is_null($data['placeholder']))
    placeholder="{{ $data['placeholder'] }}"
  @endif
>
@endif
@if ($data['input_in_div'])
</div>
@endif
@if ($data['showvalue'])
<script>
  jQuery('#{{ $data['id']}}').on('input', function(){
    jQuery('#{{ $data['id']}}_val').html(jQuery('#{{ $data['id']}}').val());
  });
  jQuery('#{{ $data['id']}}_val').html(jQuery('#{{ $data['id']}}').val());
</script>
@endif
