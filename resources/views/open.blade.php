<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.open');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(array_merge(
  config('formsbootstrap.defaults.open'),
  config('formsbootstrap.classes'),
  ['csrf' => csrf_token()]),
  $data
);
$values = [
  'id' => $data['id'],
  'novalidate' => 'novalidate',
];
$values['action'] = $data['action'];
$values['method'] = $data['method'];
$values = array_merge($values, $data['options']);
if (count($data['additionalbuttons'])){
  $vals = '';
  foreach($data['additionalbuttons'] as $btn){
    $btnval = '';
    foreach ($btn as $key => $attr){
      $btnval .= (strlen($btnval) > 0 ? ',' : '') . $key . ':"' . $attr . '"';
    }
    $vals .= (strlen($vals) > 0 ? ',{' : '{') . $btnval . '}';
  }
  $btns = '[' . $vals . ']';
}else{
  $btns = '[]';
}
?>
<form
@foreach ($values as $key => $value)
  @if (is_null($value))
  {!! $key !!}
  @else
  {!! $key !!}="{!! $value !!}"
  @endif
@endforeach>
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
<script>
  jQuery(document).ready(function() {
    jQuery('#{!! $values["id"] !!}').sebFormHelper({
      validate : {!! $data['validate'] ? 'true' : 'false' !!},
      checkonleave : {!! $data['checkonleave'] ? 'true' : 'false' !!},
      ajaxcallback : {!! is_null($data['ajaxcallback']) ? 'null' : $data['ajaxcallback'] !!},
      filldatacallback : {!! is_null($data['filldatacallback']) ? 'null' : $data['filldatacallback'] !!},
      requiredclass : '{!! $data['requiredclass'] !!}',
      requiredcheckclass : '{!! $data['requiredcheckclass'] !!}',
      selcheckclass : '{!! $data['selcheckclass'] !!}',
      requiredspecialclass : '{!! $data['requiredspecialclass'] !!}',
      verifymailclass : '{!! $data['verifymailclass'] !!}',
      verifypassclass : '{!! $data['verifypassclass'] !!}',
      verifypassmatchclass : '{!! $data['verifypassmatchclass'] !!}',
      verifypassold : '{!! $data['verifypassold'] !!}',
      resettextclass : '{!! $data['resettextclass'] !!}',
      resetselectclass : '{!! $data['resetselectclass'] !!}',
      resetcheckclass : '{!! $data['resetcheckclass'] !!}',
      resetradioclass : '{!! $data['resetradioclass'] !!}',
      csrfrefreshroute  : {!! is_null($data['csrfrefreshroute']) ? 'null' : '"' . $data['csrfrefreshroute'] . '"'  !!},
      data_build_function : {!! is_null($data['data_build_function']) ? 'null' :  $data['data_build_function']  !!},
      remove_validation_function : {!! is_null($data['remove_validation_function']) ? 'null' :  $data['remove_validation_function']  !!},
      clearonclick_function : {!! is_null($data['clearonclick_function']) ? 'null' :  $data['clearonclick_function']  !!},
      validate_function : {!! is_null($data['validate_function']) ? 'null' :  $data['validate_function']  !!},
      clear_function : {!! is_null($data['clear_function']) ? 'null' :  $data['clear_function']  !!},
      csrf : '{!! $data['csrf'] !!}',
      check_modified_on_reset : {!! $data['check_modified_on_reset'] ? 'true' : 'false' !!},
      modified_on_reset_confirm_text : '{{ FormsBootstrapUtils::translateOrPrint($data['modified_on_reset_confirm_text']) }}',
      buildbuttons: {!! $data['buildbuttons'] ? 'true' : 'false' !!},
      buildresultalert: {!! $data['buildresultalert'] ? 'true' : 'false' !!},
      alertsuccessclass: '{!! $data['alertsuccessclass'] !!}',
      alerterrorclass: '{!! $data['alerterrorclass'] !!}',
      alertcommonclass : '{!! $data['alertcommonclass'] !!}',
      alertdisplaytimeok : {!! $data['alertdisplaytimeok'] !!},
      alertdisplaytimefalse : {!! $data['alertdisplaytimefalse'] !!},
      resultok: '{{ FormsBootstrapUtils::translateOrPrint($data['resultok']) }}',
      resultfalse: '{{ FormsBootstrapUtils::translateOrPrint($data['resultfalse']) }}',
      buttondivclass: '{!! $data['buttondivclass'] !!}',
      submitbtnclass: '{!! $data['submitbtnclass'] !!}',
      additionalbuttons: {!! $btns !!},
      submitbtnlbl: '{!! FormsBootstrapUtils::translateOrPrint($data['submitbtnlbl']) !!}',
      evalajaxres_callback: {!! is_null($data['evalajaxres_callback']) ? 'null' :  $data['evalajaxres_callback']  !!},
      evalajaxres_resultmessage: {!! is_null($data['evalajaxres_resultmessage']) ? 'null' :  $data['evalajaxres_resultmessage']  !!}
    });
  });
</script>
