<?php
use \Seblhaire\Formsbootstrap\FormsBootstrapUtils;

$mandatory = config('formsbootstrap.mandatory.radio');
foreach ($mandatory as $param){
    if (!isset($data[$param])) throw new Exception('missing mandatory parameter ' . $param);
}
$data = FormsBootstrapUtils::mergeValues(array_merge(config('formsbootstrap.defaults.radio'), config('formsbootstrap.classes')),
    $data);
if ($data['required']){
  $data['divelt'] .= ' ' . $data['requiredcheckclass'];
  $data['divclass'] .= ' ' . $data['selcheckclass'];
}
$data['divclass'] .= ' ' . $data['resetradioclass'];
?>
<div class="{{ $data['divclass'] }}" id="main_{{$data['name']}}"
    @foreach ($data['mainattr'] as $mainattrkey => $mainattrvalue)
        {{$mainattrkey}}="{{$mainattrvalue}}"
    @endforeach
     >
@if(strlen($data['mainlabel']) > 0)
    <label class="{{ $data['mainlabelclass'] }}">{{$data['mainlabel']}}</label><br/>
@endif
@foreach ($data['values'] as $key => $value)
  <div class="{{ $data['divelt'] }}">

        <input type="radio" id="{{$data['name']}}_{{$key}}" class="{{ $data['inputclass'] }}" name="{{$data['name']}}" value="{{$key}}"
            @if($data['checkedvalue'] == $key)
                checked="checked"
            @endif
            @foreach ($data['attributes'] as $attkey => $attvalue)
                {{$attkey}}="{{$attvalue}}"
            @endforeach
               />
    <label class="{{$data['labelclass']}}" for="{{ $data['name']}}_{{$key}}">{{$value}}</label>
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
