<?php
use \Seblhaire\Formsbootstrap\FormsbootstrapUtils;
$data = is_null($data) ? [] : $data;
$data = FormsBootstrapUtils::mergeValues(config('formsbootstrap.defaults.password-with-confirm'), $data);
$data['newpass']['inputclass'] .= ' ' . config('formsbootstrap.class-verifypass');
$data['newpass']['validate'] = true;
$data['newpassclear']['inputclass'] .= ' ' . config('formsbootstrap.class-verifypass');
$data['oldpass']['inputclass'] .= ' ' . config('formsbootstrap.class-required');
$data['oldpass']['validate'] = false;
$data['confirmpass']['inputclass'] .= ' ' . config('formsbootstrap.class-required');
$data['confirmpass']['validate'] = false;
 ?>
 @if($data['show_old'])
  @if ($data['input_in_div'])
 <div class="{{ $data['divclass'] }}" id="fg-{{ $data['oldpass']['name'] }}">
   @endif
     {{ Form::label($data['oldpass']['name'], FormsBootstrapUtils::translateOrPrint($data['oldpass']['labeltext']), array_merge(['class' => $data['oldpass']['labelclass']], $data['oldpass']['labelattributes'])) }}
     {{ Form::pass($data['oldpass']) }}
  @if ($data['input_in_div'])
 </div>
   @endif
 @endif
 @if ($data['input_in_div'])
 <div class="{{ $data['divclass'] }}" id="fg-{{ $data['newpass']['name'] }}">
@endif
     {{ Form::label($data['newpass']['name'], FormsBootstrapUtils::translateOrPrint($data['newpass']['labeltext']), array_merge(['class' => $data['newpass']['labelclass']], $data['newpass']['labelattributes'])) }}
     @if($data['show_generate'])
      <div id="{{ $data['pwdhiddenzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }}">
        {{ Form::pass($data['newpass']) }}
        <div class="{{ $data['pwdbtn-class']}}">
          <button id="{{ $data['togglebtn-id'] }}" class="{{ $data['togglebtn-class'] }}" title="{{ formsbootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
          type="button">{!! $data['toggledbtn-icon-on'] !!}</button>
          <button id="{{ $data['generatepwdbtn-id'] }}" class="{{ $data['generatepwdbtn-class'] }}" title="{{ formsbootstrapUtils::translateOrPrint($data['generatepwdbtn-title']) }}"
          type="button">{{ FormsBootstrapUtils::translateOrPrint($data['generatepwdbtn-lbl']) }}</button>
        </div>
      </div>
      <div id="{{ $data['pwdclearzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }}" style="display:none">
         {{ Form::text($data['newpassclear']['name'], '', array_merge(['id' => $data['newpassclear']['name'],'class' => $data['newpassclear']['inputclass']], $data['newpassclear']['attributes'])) }}
        <div class="{{ $data['pwdbtn-class']}}">
          <button id="{{ $data['togglebtn-id-clear'] }}" class="{{ $data['togglebtn-class'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
          type="button">{!! $data['toggledbtn-icon-off'] !!}</button>
          <button id="{{ $data['generatepwdbtn-id-clear'] }}" class="{{ $data['generatepwdbtn-class'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['generatepwdbtn-title']) }}"
          type="button">{{ FormsBootstrapUtils::translateOrPrint($data['generatepwdbtn-lbl']) }}</button>
        </div>
      </div>
      <script>
        jQuery('#{{ $data["generatepwdbtn-id"] }}').click(function(){
            SebFormsBootstrapGeneratepass(
              '{{ addslashes(config('formsbootstrap.defaults.password_common.password_chars')) }}',
              {{ config('formsbootstrap.defaults.password_common.password_regex') }},
              {{ $data["generated_pass_length"] }},
              [
                jQuery('#{{ $data["newpass"]["name"] }}'),
                jQuery('#{{ $data["newpassclear"]["name"] }}'),
                jQuery('#{{ $data["confirmpass"]["name"] }}')
              ]
            );
            jQuery('#{{ $data["pwdclearzone-id"] }}').show();
            jQuery('#{{ $data["pwdhiddenzone-id"] }}').hide();
        });

        jQuery('#{{ $data["generatepwdbtn-id-clear"] }}').click(function(){
            SebFormsBootstrapGeneratepass(
              '{{ addslashes(config('formsbootstrap.defaults.password_common.password_chars')) }}',
              {{ config('formsbootstrap.defaults.password_common.password_regex') }},
              {{ $data["generated_pass_length"] }},
              [
                jQuery('#{{ $data["newpass"]["name"] }}'),
                jQuery('#{{ $data["newpassclear"]["name"] }}'),
                jQuery('#{{ $data["confirmpass"]["name"] }}')
              ]
            );
        });

        jQuery('#{{ $data["newpass"]["name"] }}').change(function(){
          jQuery('#{{ $data["newpassclear"]["name"] }}').val(jQuery('#{{ $data["newpass"]["name"] }}').val());
        });
        jQuery('#{{ $data["newpassclear"]["name"] }}').change(function(){
          jQuery('#{{ $data["newpass"]["name"]}}').val(jQuery('#{{ $data["newpassclear"]["name"] }}').val());
        });
        jQuery('#{{ $data["togglebtn-id"] }}').click(function(){
          jQuery('#{{ $data["pwdclearzone-id"] }}').show();
          jQuery('#{{ $data["pwdhiddenzone-id"] }}').hide();
        });
        jQuery('#{{ $data["togglebtn-id-clear"] }}').click(function(){
          jQuery('#{{ $data["pwdclearzone-id"] }}').hide();
          jQuery('#{{ $data["pwdhiddenzone-id"] }}').show();
        });
      </script>
     @elseif($data['show_clear'])
     <div id="{{ $data['pwdhiddenzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }}">
       {{ Form::pass($data['newpass']) }}
       <div class="{{ $data['pwdbtn-class']}}">
         <button id="{{ $data['togglebtn-id'] }}" class="{{ $data['togglebtn-class'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
         type="button">{!! $data['toggledbtn-icon-on'] !!}</button>
       </div>
     </div>
     <div id="{{ $data['pwdclearzone-id'] }}" class="{{ $data['pwdbtngroup-class'] }}" style="display:none">
       {{ Form::text($data['newpassclear']['name'], '', array_merge(['id' => $data['newpassclear']['name'],'class' => $data['newpassclear']['inputclass']], $data['newpassclear']['attributes'])) }}
       <div class="{{ $data['pwdbtn-class']}}">
         <button id="{{ $data['togglebtn-id-clear'] }}" class="{{ $data['togglebtn-class'] }}" title="{{ FormsBootstrapUtils::translateOrPrint($data['toggledbtn-title']) }}"
         type="button">{!! $data['toggledbtn-icon-off'] !!}</button>
       </div>
     </div>
     <script>
     jQuery('#{{ $data["newpass"]["name"] }}').change(function(){
       jQuery('#{{ $data["newpassclear"]["name"] }}').val(jQuery('#{{ $data["newpass"]["name"] }}').val());
     });
     jQuery('#{{ $data["newpassclear"]["name"] }}').change(function(){
       jQuery('#{{ $data["newpass"]["name"]}}').val(jQuery('#{{ $data["newpassclear"]["name"] }}').val());
     });
     jQuery('#{{ $data["togglebtn-id"] }}').click(function(){
       jQuery('#{{ $data["pwdclearzone-id"] }}').show();
       jQuery('#{{ $data["pwdhiddenzone-id"] }}').hide();
     });
     jQuery('#{{ $data["togglebtn-id-clear"] }}').click(function(){
       jQuery('#{{ $data["pwdclearzone-id"] }}').hide();
       jQuery('#{{ $data["pwdhiddenzone-id"] }}').show();
     });
     </script>
     @else
        {{ Form::pass($data['newpass']) }}
     @endif
     @if (strlen($data['valid-feedback']) > 0)
     <div class="valid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['valid-feedback']) }}</div>
     @endif
     @if (strlen($data['invalid-feedback']) > 0)
     <div class="invalid-feedback">{{ FormsBootstrapUtils::translateOrPrint($data['invalid-feedback']) }}</div>
     @endif
@if ($data['input_in_div'])
 </div>
<div class="{{ $data['divclass'] }}" id="fg-{{ $data['confirmpass']['name'] }}">
  @endif
    {{ Form::label($data['confirmpass']['name'], FormsBootstrapUtils::translateOrPrint($data['confirmpass']['labeltext']), array_merge(['class' => $data['confirmpass']['labelclass']], $data['confirmpass']['labelattributes'])) }}
      {{ Form::pass($data['confirmpass']) }}
    @if (strlen($data['helptext']) > 0)
    <p class="help-block">{{ $data['helptext'] }}</p>
    @endif
@if ($data['input_in_div'])
</div>
@endif
