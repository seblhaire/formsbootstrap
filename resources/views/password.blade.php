<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(array_merge(
  config('formsbootstrap.defaults.password'),
  config('formsbootstrap.defaults.password_common'),
  config('formsbootstrap.classes')
),
  $data);
if ($data['validate']){
  $data['inputclass'] .= ' ' . $data['verifypassclass'];
}else if ($data['required']){
  $data['inputclass'] .= ' ' . $data['requiredclass'];
}
$data['inputclass'] .= ' ' . $data['resettextclass'];
if (!isset($data['name']) || strlen($data['name']) == 0){
  $data['name'] = $data['id'];
}
?>
@if ($data['input_in_div'])
  <div class="{{ $data['divclass'] }}" id="fg-{{ $data['id'] }}">
@endif
{{ Form::label($data['id'], FormsBootstrapUtils::translateOrPrint($data['labeltext']), array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
{{ Form::pass($data) }}
@if (($data['required'] || $data['validate']) && strlen($data['valid-feedback']) > 0)
  <div class="valid-feedback">{{ $data['valid-feedback'] }}</div>
@endif
@if (($data['required'] || $data['validate'])  && strlen($data['invalid-feedback']) > 0)
  <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
@endif
@if (strlen($data['helptext']) > 0)
  <p class="help-block">{{ $data['helptext'] }}</p>
@endif
@if ($data['input_in_div'])
</div>
@endif
<script>
  jQuery('#{{ $data['id']}}').sebPasswordHelper({passregex : {!! $data['password_regex'] !!}});
</script>
