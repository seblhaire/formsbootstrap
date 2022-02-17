<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.checkbox');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.checkbox'), $data);
if (preg_match('/^(\w+)\[\]$/', $data['name'], $m) > 0){
  $data['id'] = $m[1];
}else{
  $data['id'] = $data['name'];
  $data['name'] .= '[]';
}
if ($data['switch']){
  $data['divelt'] .= ' '. $data['switch-class'];
  $data['attributes']['role'] = 'switch';
}
if ($data['required']){
    $data['divelt'] .= ' ' . config('formsbootstrap.class-required-check');
    $data['divclass'] .= ' ' . config('formsbootstrap.class-selcheck');
}
?>
<div class="{{ $data['divclass'] }}" id="main_{{$data['id']}}"
    @foreach ($data['mainattr'] as $mainattrkey => $mainattrvalue)
        {{$mainattrkey}}="{{$mainattrvalue}}"
    @endforeach
     >
@if(strlen($data['mainlabel']) > 0)
    <label class="{{ $data['mainlabelclass'] }}">{{ $data['mainlabel'] }}</label><br/>
@endif
@foreach ($data['values'] as $key => $value)
  <div class="{{ $data['divelt'] }}">
    <input type="checkbox" id="{{$data['id']}}_{{$key}}" class="{{ $data['inputclass'] }}" name="{{$data['name']}}" value="{{$key}}"
            @if (is_array($data['checkedvalues']))
              @if(in_array($key, $data['checkedvalues']))
                  checked="checked"
              @endif
            @else
              @if($data['checkedvalues'] == $key)
                  checked="checked"
              @endif
            @endif
            @foreach ($data['attributes'] as $attkey => $attvalue)
                {{$attkey}}="{{$attvalue}}"
            @endforeach
               />
    <label class="{{$data['labelclass']}}" for="{{$data['id']}}_{{$key}}">{{$value}}</label>
  </div>
@endforeach
@if (strlen($data['valid-feedback']) > 0)
<div class="valid-feedback">{{ $data['valid-feedback'] }}</div>
@endif
@if ($data['required'] && strlen($data['invalid-feedback']) > 0)
<div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
@endif
@if (strlen($data['helptext']) > 0)
<p class="help-block">{{ $data['helptext'] }}</p>
@endif
</div>
