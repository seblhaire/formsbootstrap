<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(array_merge(config('formsbootstrap.defaults.email'), config('formsbootstrap.classes')),
  $data);
  if (!isset($data['name']) || strlen($data['name']) == 0){
    $data['name'] = $data['id'];
  }
 ?>
 @if ($data['input_in_div'])
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['name'] }}">
  @endif
  <?php
  if ($data['required']){
    $data['inputclass'] .= ' ' . $data['requiredclass'];
  }
  if ($data['verify']){
    $data['inputclass'] .= ' ' . $data['verifymailclass'];
  }
  $data['inputclass'] .= ' ' . $data['resettextclass'];
  ?>
    {{ Form::label($data['id'], FormsBootstrapUtils::translateOrPrint($data['labeltext']), array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
    {{ Form::email($data['name'], $data['value'], array_merge(['id' => $data['id'],'class' => $data['inputclass']], $data['attributes'])) }}
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
@if ($data['verify'])
<script>
  jQuery('#{{ $data['name']}}').sebEmailHelper({emailregex : {!! $data['regex'] !!}});
</script>
@endif
