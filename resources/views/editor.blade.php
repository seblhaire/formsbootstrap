<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.editor');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.editor'), $data);
if ($data['required']){
  $data['divclass'] .= ' ' . config('formsbootstrap.class-required-special');
}
?>
<div class="{{ $data['divclass'] }}" id="{{ $data['name'] }}">
    {{ Form::label($data['name'] . '-input', $data['labeltext'], array_merge(['class' => $data['labelclass']], $data['labelattributes'])) }}
    {{ Form::textarea($data['name']. '-input', $data['value'], $data['attributes']) }}
    @if ($data['required'] && strlen($data['valid-feedback']) > 0)
    <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['valid-feedback']) }}</div>
    @endif
    @if ($data['required'] && strlen($data['invalid-feedback']) > 0)
    <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
    @endif
    @if (strlen($data['helptext']) > 0)
    <p class="help-block">{{ $data['helptext'] }}</p>
    @endif
</div>
<script>
@if (!is_null($data['configvar']))
jQuery('#{{ $data["name"] }}').sebRichTextHelper({{ $data['configvar'] }});
@elseif (!is_null($data['config']))
jQuery('#{{ $data["name"] }}').sebRichTextHelper({!! FormsBootstrapUtils::validateEditorParams($data['config'], config('formsbootstrap.editorTranslations')) !!});
@else
  jQuery('#{{ $data["name"] }}').sebRichTextHelper();
@endif
</script>
