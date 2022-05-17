<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.button');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.button'),
$data);
 ?>
{!! Form::button($data['label'], array_merge(['id' => $data['id'], 'class' => $data['class']], $data['attributes'])) !!}
@if($data['action'] != null)
<script>
  jQuery('#{!! $data['id'] !!}').on('click', function(e){ {!! $data['action'] !!} });
</script>
@endif
