<?php
if (!defined('PASSWORD_MIN_LENGTH')) define('PASSWORD_MIN_LENGTH', 8);
if (!defined('PASSWORD_MAX_LENGTH')) define('PASSWORD_MAX_LENGTH', 80);
return [
  'classes' => [
    'requiredclass' => 'verify',
    'requiredcheckclass' => 'verify-check',
    'selcheckclass' => 'selcheck',
    'requiredspecialclass' => 'verify-special',
    'verifymailclass' => 'verify-email',
    'verifypassclass' => 'verify-pass',
    'verifypassmatchclass' => 'verify-pass-match',
    'verifypassold' => 'verify-pass-old',
    'resettextclass' => 'resettext',
    'resetselectclass' => 'resetselect',
    'resetcheckclass' => 'resetcheck',
    'resetradioclass' => 'resetradio',
    'resetspecialclass' => 'resetspecial'
  ],
  'mandatory' =>  [
    'open' => ['id', 'ajaxcallback'],
    'hidden' => ['id', 'value'],
    'button' => ['id', 'label'],
    'checkbox' => ['name', 'values'],
    'radio' => ['name', 'values', 'checkedvalue'],
    'select' => ['name'],
    'text' => ['id', 'labeltext'],
    'number' => ['id', 'labeltext'],
    'colorpicker' => ['id', 'labeltext', 'value'],
    'range' => ['id', 'labeltext'],
    'textarea' => ['id', 'labeltext'],
    'editor' => ['id', 'labeltext']
  ],
  'editorTranslations' => [
      'title' => "#formsbootstrap::editor.title#",
      'white' => "#formsbootstrap::editor.white#",
      'black' => "#formsbootstrap::editor.black#",
      'brown' => "#formsbootstrap::editor.brown#",
      'beige' => "#formsbootstrap::editor.beige#",
      'darkBlue' => "#formsbootstrap::editor.darkBlue#",
      'blue' => "#formsbootstrap::editor.blue#",
      'lightBlue' => "#formsbootstrap::editor.lightBlue#",
      'darkRed' => "#formsbootstrap::editor.darkRed#",
      'red' => "#formsbootstrap::editor.red#",
      'darkGreen' => "#formsbootstrap::editor.darkGreen#",
      'green' => "#formsbootstrap::editor.green#",
      'purple' => "#formsbootstrap::editor.purple#",
      'darkTurquois' => "#formsbootstrap::editor.darkTurquois#",
      'turquois' => "#formsbootstrap::editor.turquois#",
      'darkOrange' => "#formsbootstrap::editor.darkOrange#",
      'orange' => "#formsbootstrap::editor.orange#",
      'yellow' => "#formsbootstrap::editor.yellow#",
      'imageURL' => "#formsbootstrap::editor.imageURL#",
      'fileURL' => "#formsbootstrap::editor.fileURL#",
      'linkText' => "#formsbootstrap::editor.linkText#",
      'url' => "#formsbootstrap::editor.url#",
      'size' => "#formsbootstrap::editor.size#",
      'responsive' => "#formsbootstrap::editor.responsive#",
      'text' => "#formsbootstrap::editor.text#",
      'openIn' => "#formsbootstrap::editor.openIn#",
      'sameTab' => "#formsbootstrap::editor.sameTab#",
      'newTab' => "#formsbootstrap::editor.newTab#",
      'align' => "#formsbootstrap::editor.align#",
      'left' => "#formsbootstrap::editor.left#",
      'center' => "#formsbootstrap::editor.center#",
      'right' => "#formsbootstrap::editor.right#",
      'rows' => "#formsbootstrap::editor.rows#",
      'columns' => "#formsbootstrap::editor.columns#",
      'add' => "#formsbootstrap::editor.add#",
      'pleaseEnterURL' => "#formsbootstrap::editor.pleaseEnterURL#",
      'videoURLnotSupported' => "#formsbootstrap::editor.videoURLnotSupported#",
      'pleaseSelectImage' => "#formsbootstrap::editor.pleaseSelectImage#",
      'pleaseSelectFile' => "#formsbootstrap::editor.pleaseSelectFile#",
      'bold' => "#formsbootstrap::editor.bold#",
      'italic' => "#formsbootstrap::editor.italic#",
      'underline' => "#formsbootstrap::editor.underline#",
      'alignLeft' => "#formsbootstrap::editor.alignLeft#",
      'alignCenter' => "#formsbootstrap::editor.alignCenter#",
      'alignRight' => "#formsbootstrap::editor.alignRight#",
      'addOrderedList' => "#formsbootstrap::editor.addOrderedList#",
      'addUnorderedList' => "#formsbootstrap::editor.addUnorderedList#",
      'addHeading' => "#formsbootstrap::editor.addHeading#",
      'addFont' => "#formsbootstrap::editor.addFont#",
      'addFontColor' => "#formsbootstrap::editor.addFontColor#",
      'addFontSize'  => "#formsbootstrap::editor.addFontSize#",
      'addImage' => "#formsbootstrap::editor.addImage#",
      'addVideo' => "#formsbootstrap::editor.addVideo#",
      'addFile' => "#formsbootstrap::editor.addFile#",
      'addURL' => "#formsbootstrap::editor.addURL#",
      'addTable' => "#formsbootstrap::editor.addTable#",
      'removeStyles' => "#formsbootstrap::editor.removeStyles#",
      'code' => "#formsbootstrap::editor.code#",
      'undo' => "#formsbootstrap::editor.undo#",
      'redo' => "#formsbootstrap::editor.redo#",
      'close' => "#formsbootstrap::editor.close#"
  ],
  'defaults' =>[
      'button' => ['attributes' => [], 'action' => null, 'class' => 'btn btn-secondary'],
      'checkbox' => [
        'checkedvalues' => null,
        'attributes' => [],
        'mainlabel' => '',
        'mainlabelclass' => 'form-label',
        'inputclass' => 'form-check-input',
        'labelclass' => 'form-check-label',
        'mainattr' => [],
        'divclass' => "mb-3",
        'divelt' => "form-check form-check-inline",
        'switch' => false,
        'switch-class' => 'form-switch',
        'required' => false,
        'helptext' => '',
        'invalid-feedback' => "#formsbootstrap::messages.checkbox-required#",
        'valid-feedback' => '',
      ],
      'hidden' => [
        'attributes' => [],
      ],
      'radio' => [
        'checkedvalue' => null,
        'attributes' => [],
        'mainlabel' => '',
        'mainlabelclass' => 'form-label',
        'mainattr' => [],
        'inputclass' => 'form-check-input',
        'labelclass' => 'form-check-label',
        'divclass' => "mb-3",
        'divelt' => "form-check form-check-inline",
        'required' => false,
        'helptext' => '',
        'invalid-feedback' => "#formsbootstrap::messages.checkbox-required#",
        'valid-feedback' => '',
      ],
      'open' => [
        'action' => '',
        'method' => 'post',
        'class' => '',
        'options' => [],
        'validate' => true,
        'filldatacallback' => null,
        'data_build_function' => null,
        'csrf' => null,
        'remove_validation_function' => null,
        'clearonclick_function' => null,
        'validate_function' => null,
        'clear_function' => null,
        'checkonleave' => true,
        'check_modified_on_reset' => true,
        'modified_on_reset_confirm_text' => "#formsbootstrap::messages.modified_on_reset_confirm_text#",
        'buildbuttons' => true,
        'buildresultalert' => true,
        'alertcommonclass' => 'alert',
        'alertsuccessclass' => 'alert-success',
        'alerterrorclass' => 'alert-danger',
        'buttondivclass' => "mb-3 btngroup",
        'submitbtnclass' => 'btn btn-primary',
        'additionalbuttons' => [],
        'submitbtnlbl' => "#formsbootstrap::messages.send#",
        'alertdisplaytimeok' => 4000,
        'alertdisplaytimefalse' => 8000,
        'resultok' => "#formsbootstrap::messages.resultok#",
        'resultfalse' => "#formsbootstrap::messages.resultfalse#",
        'tokenexpired' => "#formsbootstrap::messages.tokenexpired#",
        "evalajaxres_callback" => null,
        "evalajaxres_resultmessage" => null,
        'resetvalues' => [],
      ],
      'password-with-confirm' => [
        'oldpass' => [
            'id' => 'old_password',
            'name' => 'old_password',
            'labeltext' => "#formsbootstrap::messages.old_password#",
            'inputclass' => 'form-control',
            'labelclass' => 'form-label',
            'attributes' => ['autocomplete' => "current-password"],
            'labelattributes' => [],
        ],
        'newpass' =>[
          'name' => 'password',
          'id' => 'password',
          'labeltext' => "#formsbootstrap::messages.new_password#",
          'inputclass' => 'form-control',
          'labelclass' => 'form-label',
          'attributes' => ['autocomplete' => "new-password"],
          'labelattributes' => [],
        ],
        'newpassclear' => [
          'name' => 'password_clear',
          'id' => 'password_clear',
          'inputclass' => 'form-control',
          'attributes' => [],
        ],
        'confirmpass' => [
          'name' => 'password_confirmation',
          'id' => 'password_confirmation',
          'labeltext' => "#formsbootstrap::messages.confirm_password#",
          'inputclass' => 'form-control',
          'labelclass' => 'form-label',
          'attributes' => [],
          'labelattributes' => [],
        ],
        'pwdhiddenzone-id' => 'password-hidden-div',
        'pwdclearzone-id' => 'password-clear-div',
        'show_old' => true,
        'show_generate' => true,
        'show_clear' => true,
        'show_rules' => true,
        'showrulesbtntext' => '#formsbootstrap::messages.showrules#',
        'password_rules_modal_head' => '#formsbootstrap::messages.password_rules#',
        'password_rules_intro' => '#formsbootstrap::messages.password_rules_intro#',
        'password_rules_list' => [],
        'close_rules' => '#formsbootstrap::messages.close_rules#',
        'input_in_div' => true,
        'generated_pass_length' => PASSWORD_MIN_LENGTH + 4,
        'helptext' => '',
        'pwdbtngroup-class' => 'input-group',
        'togglebtn-class' => 'btn btn-primary',
        'toggledbtn-title' => '#formsbootstrap::messages.display_pwd#',
        'toggledbtn-icon-on' => '<i class="far fa-eye"></i>',
        'toggledbtn-icon-off' => '<i class="far fa-eye-slash"></i>',
        'generatebtn-icon' => '<i class="fa-solid fa-gears"></i>',
        'generatepwdbtn-class' => 'btn btn-outline-secondary',
        'generatepwdbtn-lbl' => '#formsbootstrap::messages.generate#',
        'generatepwdbtn-title' => '#formsbootstrap::messages.generate_long#',
        'oldpass-feedback' => "#formsbootstrap::messages.incorrectoldpass#",
        'oldpass-validfeedback' => '',
        'invalid-feedback' => "#formsbootstrap::messages.invalidpassword#",
        'nomatch-feedback' => "#formsbootstrap::messages.nomatchpassword#",
        'nomatch-validfeedback' => '',
        'valid-feedback' => '',
        'divclass' => "mb-3",
        'checkoldpassurl' => null,
        'checkoldpass_callback' => null,
        'csrf' => null,
      ],
      'password' => [
        'labeltext' => "#formsbootstrap::messages.password#",
        'required' => false,
        'validate' => false,
        'helptext' => '',
        'input_in_div' => true,
        'inputclass' => 'form-control',
        'labelclass' => 'form-label',
        'attributes' => [],
        'labelattributes' => [],
        'invalid-feedback' => "#formsbootstrap::messages.invalidpassword#",
        'valid-feedback' => '',
        'divclass' => "mb-3",
      ],
      'password_common' => [
        'min_password' => PASSWORD_MIN_LENGTH,
        'max_password' => PASSWORD_MAX_LENGTH,
        'password_regex' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\^!\-_?§=@$&§°\[\]{}£¢€*#%\/\\\\.;,:+|()])[A-Za-z\d\^!\-_\?§=@$&\§°\[\]{}£¢€*#%\/\\\\.;,:+|()]{" . PASSWORD_MIN_LENGTH . ',' . PASSWORD_MAX_LENGTH . "}$/",
        'password_regex_php' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\^!\-_?§=@$&§°\[\]{}£¢€*#%\/\\\\\\\\.;,:+|()])[A-Za-z\d\^!\-_\?§=@$&\§°\[\]{}£¢€*#%\/\\\\\\\\.;,:+|()]{' . PASSWORD_MIN_LENGTH . ',' . PASSWORD_MAX_LENGTH .'}$/',
        'authorized_special_chars' => '^!?-_§=@$£¢€&§°[]{}*#%/\.;,:+|()',
        'password_chars' => '123456789ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz^!?-§=@$£¢€&§°[]{}*#%/\.;,:+|()',
      ],
      'select' => [
        'labeltext' => 'null',
        'values' => [],
        'multiple' => false,
        'default' => '',
        'helptext' => '',
        'input_in_div' => true,
        'inputclass' => 'form-select',
        'labelclass' => 'form-label',
        'attributes' => [],
        'labelattributes' => [],
        'required' => false,
        'invalid-feedback' => "#formsbootstrap::messages.required#",
        'valid-feedback' => '',
        'divclass' => "mb-3",
        'feedback' => true
      ],
      'submit' => [
        'id' => 'submit',
        'label' => "#formsbootstrap::messages.send#",
        'class' => 'btn btn-primary',
        'attributes' => []
      ],
      'colorpicker' => [
          'input_in_div' => true,
          'inputclass' => 'form-control form-control-color',
           'labelclass' => 'form-label',
          'attributes' => [],
          'labelattributes' => [],
          'divclass' => "mb-3",
          'title' => '#formsbootstrap::messages.colorpicker#'
      ],
      'range' => [
          'value' => null,
          'input_in_div' => true,
          'inputclass' => 'form-control form-range formsbootstrap-range',
          'labelclass' => 'form-label',
          'attributes' => [],
          'groupclass' => 'input-group',
          'groupeltclass' => 'input-group-text formsbootstrap-inputgt',
          'groupeltresclass' => 'input-group-text',
          'showvalue' => true,
          'valueprefix' => '#formsbootstrap::messages.rangevalueprefix#',
          'show_bounds' => true,
          'labelattributes' => [],
          'divclass' => "mb-3",
          'min' => null,
          'max' => null,
          'step' => null
      ],
      'number' => [
          'value' => null,
          'required' => false,
          'helptext' => '',
          'input_in_div' => true,
          'inputclass' => 'form-control',
           'labelclass' => 'form-label',
          'attributes' => [],
          'labelattributes' => [],
          'invalid-feedback' => "#formsbootstrap::messages.number_required#",
          'valid-feedback' => '',
          'divclass' => "mb-3"
      ],
      'text' => [
          'value' => null,
          'required' => false,
          'input_in_div' => true,
          'inputclass' => 'form-control',
           'labelclass' => 'form-label',
          'attributes' => [],
          'labelattributes' => [],
          'helptext' => '',
          'invalid-feedback' => "#formsbootstrap::messages.required#",
          'valid-feedback' => '',
          'divclass' => "mb-3"
      ],
      'textarea' => [
        'value' => null,
        'required' => false,
        'helptext' => '',
        'input_in_div' => true,
        'inputclass' =>'form-control',
        'labelclass' => 'form-label',
        'attributes' => [],
        'labelattributes' => [],
        'invalid-feedback' => "#formsbootstrap::messages.required#",
        'valid-feedback' => '',
        'divclass' => "mb-3"
      ],
      'editor' => [
        'value' => null,
        'required' => false,
        'helptext' => '',
        'inputclass' =>'form-control',
        'labelclass' => 'form-label',
        'addresetclass' => true,
        'attributes' => [],
        'labelattributes' => [],
        'invalid-feedback' => "#formsbootstrap::messages.required#",
        'valid-feedback' => '',
        'divclass' => "mb-3",
        'config' => [
          'useParagraph' => true,
          'imageUpload' => false,
          'fileUpload' => false,
        ],
        'configvar' => null,
        'translations' => null
      ],
      'email' => [
        'name' => 'email',
        'id' => 'email',
        'labeltext' => "#formsbootstrap::messages.email#",
        'value' => null,
        'required' => false,
        'verify' => true,
        'helptext' => '',
        'input_in_div' => true,
        'inputclass' => 'form-control',
        'labelclass' => 'form-label',
        'attributes' => [],
        'labelattributes' => [],
        'invalid-feedback' => "#formsbootstrap::messages.invalidemail#",
        'valid-feedback' => '',
        'divclass' => "mb-3",
        'regex' => "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/"
      ],
    ]
];
