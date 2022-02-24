<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.open');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.open'), $data);
$values = [
  'id' => $data['id'],
  'novalidate' => 'novalidate',
];
$values['action'] = $data['action'];
$values['method'] = $data['method'];
/*
if ($data['validate']){
  $values['dovalidate'] = 1;
}else{
  $values['dovalidate'] = 0;
}*/
$values = array_merge($values, $data['options']);
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
@if ($data['validate'])
<script>
jQuery(document).ready(function() {
  SebFormsBootstrapClearOnClick({!! $values['id'] !!}_params);
});
var {!! $values['id'] !!}_params = {
  formId : "{!! $values['id'] !!}",
  requiredId : "{!! config('formsbootstrap.class-required') !!}",
  requiredCheckedId : "{!! config('formsbootstrap.class-required-check') !!}",
  requiredSpecialId : "{!! config('formsbootstrap.class-required-special') !!}",
  requiredSelcheckId :"{!! config('formsbootstrap.class-selcheck') !!}",
  requiredMailId :"{!! config('formsbootstrap.class-verifymail') !!}",
  requiredPassId :"{!! config('formsbootstrap.class-verifypass') !!}",
  emailregex : {!! config('formsbootstrap.defaults.email.regex') !!},
  passregex : {!! config('formsbootstrap.password_regex') !!}
};
jQuery('#{!! $values["id"] !!}').on('submit', function(event){
  event.preventDefault();
  SebFormsBootstrapResetForm({!! $values['id'] !!}_params);
  if (!SebFormsBootstrapValidateForm({!! $values['id'] !!}_params)){
    event.stopPropagation();
  }
@if (!is_null($data['ajaxcallback']))
  else{
    {!! $data['ajaxcallback'] !!}(jQuery('#{!! $values["id"] !!}'));
  }
@endif
});
</script>
@elseif(!is_null($data['ajaxcallback']))
<script>
jQuery('#{!! $values["id"] !!}').on('submit', function(event){
  event.preventDefault();
  {!! $data['ajaxcallback'] !!}(jQuery('#{!! $values["id"] !!}').first());
});
</script>
@endif
