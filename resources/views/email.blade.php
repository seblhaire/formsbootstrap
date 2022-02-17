<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.email'), $data);
 ?>
 @if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
  @endif
  <?php
  if ($data['required']){
    $data['inputclass'] .= ' ' . config('formsbootstrap.class-required');
  }
  if ($data['verify']){
    $data['inputclass'] .= ' ' .config('formsbootstrap.class-verifymail');
  }
  ?>
    {{ Form::label($data['name'], FormsBootstrapUtils::translateOrPrint($data['labeltext']), array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
    {{ Form::email($data['name'], $data['value'], array_merge([
      'class' => $data['inputclass']], $data['attributes'])) }}
    @if (strlen($data['valid-feedback']) > 0)
    <div class="valid-feedback">{{ $data['valid-feedback'] }}</div>
    @endif
    @if (strlen($data['invalid-feedback']) > 0)
    <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
    @endif
    @if (strlen($data['helptext']) > 0)
    <p class="help-block">{{ $data['helptext'] }}</p>
    @endif
    @if ($data['input_in_div'])
</div>
@endif
