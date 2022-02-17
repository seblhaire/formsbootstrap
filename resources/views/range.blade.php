<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.select');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.range'), $data);
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
@endif
{{ Form::label($data['name'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
@if ($data['showvalue'] || $data['show_bounds'])
<div class="{{ $data['groupclass'] }}">
  @if (!is_null($data['min']) && $data['show_bounds'])
  <span class="{{ $data['groupeltclass'] }}">{{ $data['min'] }}</span>
  @endif
  <input type="range" class="{{ $data['inputclass'] }}" id="{{ $data['name'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}"
    @if (!is_null($data['min']))
      min="{{ $data['min'] }}"
    @endif
    @if (!is_null($data['max']))
      max="{{ $data['max'] }}"
    @endif
    @if (!is_null($data['step']))
      step="{{ $data['step'] }}"
    @endif
  >
  @if (!is_null($data['max']) && $data['show_bounds'])
  <span class="{{ $data['groupeltclass'] }}">{{ $data['max'] }}</span>
  @endif
  @if ($data['showvalue'])
  <span class="{{ $data['groupeltresclass'] }}">
    {{ FormsBootstrapUtils::translateOrPrint($data['valueprefix']) }}:&nbsp;<span id="{{ $data['name'] }}_val"></span>
  </span>
  @endif
</div>
@else
<input type="range" class="{{ $data['inputclass'] }}" id="{{ $data['name'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}"
  @if (!is_null($data['min']))
    min="{{ $data['min'] }}"
  @endif
  @if (!is_null($data['max']))
    max="{{ $data['max'] }}"
  @endif
  @if (!is_null($data['step']))
    step="{{ $data['step'] }}"
  @endif
>
@endif
@if ($data['input_in_div'])
</div>
@endif
@if ($data['showvalue'])
<script>
  jQuery('#{{ $data['name']}}').on('change mousemove', function(){
    jQuery('#{{ $data['name']}}_val').html(jQuery('#{{ $data['name']}}').val());
  });
  jQuery('#{{ $data['name']}}_val').html(jQuery('#{{ $data['name']}}').val());
</script>
@endif
