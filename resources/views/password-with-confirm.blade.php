<?php
use \Seblhaire\Formsbootstrap\FormsbootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(array_merge(
    config('formsbootstrap.defaults.password-with-confirm'),
    config('formsbootstrap.defaults.password_common'),
    config('formsbootstrap.classes'),
    ['csrf' => csrf_token()]
  ), $data);
$data['newpass']['inputclass'] .= ' ' . $data['verifypassclass'];
$data['newpass']['validate'] = true;
$data['oldpass']['inputclass'] .= ' ' . $data['verifypassold'];
$data['oldpass']['validate'] = false;
$data['confirmpass']['inputclass'] .= ' ' . $data['verifypassmatchclass'];
$data['confirmpass']['validate'] = false;
if (count($data['password_rules_list']) == 0){
  $passrules = FormsBootstrapUtils::complileRules();
}else{
  $passrules = $data['password_rules_list'];
}
$data['oldpass']['inputclass'] .= ' ' . $data['resettextclass'];
$data['newpass']['inputclass'] .= ' ' . $data['resettextclass'];
$data['confirmpass']['inputclass'] .= ' ' . $data['resettextclass'];
$data['oldpass']['attributes']['data-maininput'] = '#' . $data['newpass']['name'];
$data['confirmpass']['attributes']['data-maininput'] = '#' . $data['newpass']['name'];
?>
@if($data['show_old'])
  @if ($data['input_in_div'])
      <div class="{{ $data['divclass'] }}" id="fg-{{ $data['oldpass']['name'] }}">
  @endif
  {{ Form::label($data['oldpass']['name'], FormsBootstrapUtils::translateOrPrint($data['oldpass']['labeltext']), array_merge(['class' => $data['oldpass']['labelclass']], $data['oldpass']['labelattributes'])) }}
  {{ Form::pass($data['oldpass']) }}
  @if (strlen($data['oldpass-validfeedback']) > 0)
    <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['oldpass-validfeedback']) }}</div>
  @endif
  @if (strlen($data['oldpass-feedback']) > 0)
    <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['oldpass-feedback']) }}</div>
  @endif
  @if ($data['input_in_div'])
    </div>
  @endif
@endif
@if ($data['input_in_div'])
      <div class="{{ $data['divclass'] }}" id="fg-{{ $data['newpass']['name'] }}">
@endif
     {{ Form::label($data['newpass']['name'], FormsBootstrapUtils::translateOrPrint($data['newpass']['labeltext']), array_merge(['class' => $data['newpass']['labelclass']], $data['newpass']['labelattributes'])) }}
@if($data['show_generate'])
      <div id="{{ $data['pwdhiddenzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }} {{ $data['newpass']['name']}}-div">
        {{ Form::pass($data['newpass']) }}
          <button class="{{ $data['togglebtn-class'] }} {{$data['newpass']['name']}}-btn" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
          type="button">{!! $data['toggledbtn-icon-on'] !!}</button>
          <button class="{{ $data['generatepwdbtn-class'] }} {{$data['newpass']['name']}}-gen" title="{{ FormsBootstrapUtils::translateOrPrint($data['generatepwdbtn-title']) }}"
          type="button">{!! $data['generatebtn-icon'] !!}</button>
          @if ($data['show_rules'])
            <button class="{{ $data['generatepwdbtn-class'] }}" type="button" data-bs-toggle="modal" data-bs-target="#{{$data['newpass']['name']}}-rule-modal" title="{{ formsbootstrapUtils::translateOrPrint($data['showrulesbtntext']) }}"><i class="fa-solid fa-ruler"></i></button>
          @endif
        @if (strlen($data['valid-feedback']) > 0)
          <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['valid-feedback']) }}</div>
        @endif
        @if (strlen($data['invalid-feedback']) > 0)
          <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
        @endif
      </div>
      <div id="{{ $data['pwdclearzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }} {{ $data['newpass']['name']}}-div" style="display:none">
         {{ Form::text($data['newpassclear']['name'], '', array_merge(['id' => $data['newpassclear']['name'],'class' => $data['newpassclear']['inputclass']], $data['newpassclear']['attributes'])) }}
          <button class="{{ $data['togglebtn-class'] }} {{$data['newpass']['name']}}-btn" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
          type="button">{!! $data['toggledbtn-icon-off'] !!}</button>
          <button class="{{ $data['generatepwdbtn-class'] }} {{$data['newpass']['name']}}-gen" title="{{ FormsBootstrapUtils::translateOrPrint($data['generatepwdbtn-title']) }}"
          type="button">{!! $data['generatebtn-icon'] !!}</button>
          @if ($data['show_rules'])
            <button class="{{ $data['generatepwdbtn-class'] }}" type="button" data-bs-toggle="modal" data-bs-target="#{{$data['newpass']['name']}}-rule-modal" title="{{ formsbootstrapUtils::translateOrPrint($data['showrulesbtntext']) }}"><i class="fa-solid fa-ruler"></i></button>
          @endif
      </div>
@elseif($data['show_clear'])
     <div id="{{ $data['pwdhiddenzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }} {{ $data['newpass']['name']}}-div">
       {{ Form::pass($data['newpass']) }}
       <div class="{{ $data['pwdbtn-class']}}">
         <button class="{{ $data['togglebtn-class'] }} {{$data['newpass']['name']}}-btn" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
         type="button">{!! $data['toggledbtn-icon-on'] !!}</button>
         @if ($data['show_rules'])
           <button class="{{ $data['generatepwdbtn-class'] }}" type="button" action="return false" data-bs-toggle="modal" data-bs-target="#{{$data['newpass']['name']}}-rule-modal" title="{{ formsbootstrapUtils::translateOrPrint($data['showrulesbtntext']) }}"><i class="fa-solid fa-ruler"></i></button>
         @endif
       </div>
       @if (strlen($data['valid-feedback']) > 0)
         <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['valid-feedback']) }}</div>
       @endif
       @if (strlen($data['invalid-feedback']) > 0)
         <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
       @endif
     </div>
     <div id="{{ $data['pwdclearzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }} {{ $data['newpass']['name']}}-div" style="display:none">
       {{ Form::text($data['newpassclear']['name'], '', array_merge(['id' => $data['newpassclear']['name'],'class' => $data['newpassclear']['inputclass']], $data['newpassclear']['attributes'])) }}
       <div class="{{ $data['pwdbtn-class']}}">
         <button class="{{ $data['togglebtn-class'] }} {{$data['newpass']['name']}}-btn" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
         type="button">{!! $data['toggledbtn-icon-off'] !!}</button>
       </div>
     </div>
@else
    {{ Form::pass($data['newpass']) }}
    @if (strlen($data['valid-feedback']) > 0)
      <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['valid-feedback']) }}</div>
    @endif
    @if (strlen($data['invalid-feedback']) > 0)
      <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
    @endif
@endif
@if ($data['input_in_div'])
  </div>
@if ($data['show_rules'])
  <div class="modal fade" id="{{$data['newpass']['name']}}-rule-modal" tabindex="-1" aria-labelledby="{{$data['newpass']['name']}}-rule-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{$data['newpass']['name']}}-rule-label">{{ FormsBootstrapUtils::translateOrPrint($data['password_rules_modal_head']) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ FormsBootstrapUtils::translateOrPrint($data['close_rules']) }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['close_rules']) }}"></button>
      </div>
      <div class="modal-body">
        <p>{{ FormsBootstrapUtils::translateOrPrint($data['password_rules_intro']) }}</p>
        <ul>
          @foreach($passrules as $rule)
            <li>{{ $rule }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endif
  <div class="{{ $data['divclass'] }}" id="fg-{{ $data['confirmpass']['name'] }}">
@endif
    {{ Form::label($data['confirmpass']['name'], FormsBootstrapUtils::translateOrPrint($data['confirmpass']['labeltext']), array_merge(['class' => $data['confirmpass']['labelclass']], $data['confirmpass']['labelattributes'])) }}
    {{ Form::pass($data['confirmpass']) }}
    @if ($data['nomatch-validfeedback'])
      <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['nomatch-validfeedback']) }}</div>
    @endif
    @if ($data['nomatch-feedback'])
      <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['nomatch-feedback']) }}</div>
    @endif
@if (strlen($data['helptext']) > 0)
    <p class="help-block">{{ $data['helptext'] }}</p>
@endif
@if ($data['input_in_div'])
    </div>
@endif
@if($data['show_generate'] || $data['show_clear'])
<script>
  jQuery('#{{ $data['newpass']['name']}}').sebPasswordHelper({
    passregex : {!! $data['password_regex'] !!},
    passchars :   '{{ addslashes($data['password_chars']) }}',
    genlength : {{ $data["generated_pass_length"] }},
    confirminput : '#{{ $data['confirmpass']['name'] }}',
    clearinput : '#{{ $data['newpassclear']['name'] }}'
@if($data['show_old'])
    , oldinput: '#{{ $data['oldpass']['name']}}',
    checkoldpassurl: {!! is_null($data['checkoldpassurl']) ? 'null' : '"' . $data['checkoldpassurl'] . '"' !!},
    csrfrefreshroute  : {!! is_null($data['csrfrefreshroute']) ? 'null' : '"' . $data['csrfrefreshroute'] . '"'  !!},
    csrf : '{!! $data['csrf'] !!}'
@endif
  });
</script>
@endif
