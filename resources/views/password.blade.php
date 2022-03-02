<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.password'), $data);

if ($data['validate']){
  $data['inputclass'] .= ' ' . config('formsbootstrap.class-verifypass');
}else if ($data['required']){
  $data['inputclass'] .= ' ' . config('formsbootstrap.class-required');
}
 ?>
 @if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
@endif
    {{ Form::label($data['name'], FormsBootstrapUtils::translateOrPrint($data['labeltext']), array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
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
  jQuery('#{{ $data['name']}}').sebPasswordHelper({passregex : '{{ config('formsbootstrap.defaults.password_common')}}'});
</script>
