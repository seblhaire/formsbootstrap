<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.open');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.open'), $data);
$values = [
  'id' => $data['id'],
  //'novalidate'
];
$values['action'] = $data['action'];
$values['method'] = $data['method'];
if ($data['validate']){
  $values['class'] = (strlen($data['class']) > 1 ? $data['class'] . ' ' : '') . 'needs-validation';
  $values['novalidate'] = null;
}
$values = array_merge($values, $data['options']);
?>
<form
@foreach ($values as $key => $value)
  @if (is_null($value))
  {!! $key !!}
  @else
  {!! $key !!}="{!! $value !!}"
  @endif
@endforeach
>
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
@if ($data['validate'])
<script>
jQuery('#{!! $values["id"] !!}').on('submit', function(event){
  if(!this.checkValidity()){
    event.preventDefault();
    event.stopPropagation();
    jQuery(this).addClass('was-validated');
  }else{
    event.preventDefault();
    jQuery(this).addClass('was-validated');
    @if (!is_null($data['ajaxcallback']))
    {!! $data['ajaxcallback'] !!}(jQuery('#{!! $values["id"] !!}'));
    @endif
  }

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
