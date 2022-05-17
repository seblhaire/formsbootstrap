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
      modified_on_reset_confirm_text : '{{ FormsBootstrapUtils::translateOrPrint($data['modified_on_reset_confirm_text']) }}'
    });
  });
</script>
