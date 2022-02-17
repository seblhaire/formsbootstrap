<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.textarea');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.textarea'), $data);
?>
@if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
  @endif
  <?php
  if ($data['required']){
    $data['inputclass'] .= ' ' . config('formsbootstrap.class-required');
  }
   ?>
    {{ Form::label($data['name'], $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
    {{ Form::textarea($data['name'], $data['value'], array_merge(['class' => $data['inputclass']], $data['attributes'])) }}
    @if ($data['required'] && strlen($data['valid-feedback']) > 0)
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
