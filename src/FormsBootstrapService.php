<?php
namespace Seblhaire\Formsbootstrap;

use Illuminate\Support\Facades\Validator;
use function Stringy\create as s;

/**
 * Helpers for package formsbootstrap
 */
class FormsBootstrapService implements FormsBootstrapServiceContract {

    public function bsOpen($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.open'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.open'),
                        config('formsbootstrap.classes'),
                        ['csrf' => csrf_token()]
                ), $data
        );
        $values = [
            'id' => $data['id'],
            'novalidate' => 'novalidate',
        ];
        $values['action'] = $data['action'];
        $values['method'] = $data['method'];
        $values = array_merge($values, $data['options']);
        if (count($data['additionalbuttons'])) {
            $vals = '';
            foreach ($data['additionalbuttons'] as $btn) {
                $btnval = '';
                foreach ($btn as $key => $attr) {
                    $btnval .= (strlen($btnval) > 0 ? ',' : '') . '"' . $key . '":"' . $attr . '"';
                }
                $vals .= (strlen($vals) > 0 ? ',{' : '{') . $btnval . '}';
            }
            $btns = '[' . $vals . ']';
        } else {
            $btns = '[]';
        }
        if (count($data['resetvalues'])) {
            $vals = '';
            foreach ($data['resetvalues'] as $key => $val) {
                $vals .= (strlen($vals) > 0 ? ',{"' : '{"key": "') . $key . '","value":"' . $val . '"}';
            }
            $resetvalues = '[' . $vals . ']';
        } else {
            $resetvalues = '[]';
        }
        $output = '<form';
        foreach ($values as $key => $value) {
            if (is_null($value)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $value . '"';
            }
        }
        $output .= '>' . PHP_EOL . '<input type="hidden" id="_token" name="_token" value="' . csrf_token() . '" />' . PHP_EOL;
        $output .= $this->buildJsCode([
            'jQuery(document).ready(function() {' => [
                'jQuery("#' . $values["id"] . '").sebFormHelper({' => [
                    'validate' => $data['validate'] ? 'true' : 'false',
                    'checkonleave' => $data['checkonleave'] ? 'true' : 'false',
                    'ajaxcallback' => is_null($data['ajaxcallback']) ? 'null' : $data['ajaxcallback'],
                    'filldatacallback' => is_null($data['filldatacallback']) ? 'null' : $data['filldatacallback'],
                    'requiredclass' => '"' . $data['requiredclass'] . '"',
                    'requiredcheckclass' => '"' . $data['requiredcheckclass'] . '"',
                    'selcheckclass' => '"' . $data['selcheckclass'] . '"',
                    'requiredspecialclass' => '"' . $data['requiredspecialclass'] . '"',
                    'verifymailclass' => '"' . $data['verifymailclass'] . '"',
                    'verifypassclass' => '"' . $data['verifypassclass'] . '"',
                    'verifypassmatchclass' => '"' . $data['verifypassmatchclass'] . '"',
                    'verifypassold' => '"' . $data['verifypassold'] . '"',
                    'resettextclass' => '"' . $data['resettextclass'] . '"',
                    'resetselectclass' => '"' . $data['resetselectclass'] . '"',
                    'resetcheckclass' => '"' . $data['resetcheckclass'] . '"',
                    'resetradioclass' => '"' . $data['resetradioclass'] . '"',
                    'resetspecialclass' => '"' . $data['resetspecialclass'] . '"',
                    'data_build_function' => is_null($data['data_build_function']) ? 'null' : $data['data_build_function'],
                    'remove_validation_function' => is_null($data['remove_validation_function']) ? 'null' : $data['remove_validation_function'],
                    'clearonclick_function' => is_null($data['clearonclick_function']) ? 'null' : $data['clearonclick_function'],
                    'validate_function' => is_null($data['validate_function']) ? 'null' : $data['validate_function'],
                    'clear_function' => is_null($data['clear_function']) ? 'null' : $data['clear_function'],
                    'csrf' => '"' . $data['csrf'] . '"',
                    'check_modified_on_reset' => $data['check_modified_on_reset'] ? 'true' : 'false',
                    'modified_on_reset_confirm_text' => '"' . $this->translateOrPrint($data['modified_on_reset_confirm_text']) .'"' ,
                    'buildbuttons' => $data['buildbuttons'] ? 'true' : 'false',
                    'buildresultalert' => $data['buildresultalert'] ? 'true' : 'false',
                    'alertsuccessclass' => '"' . $data['alertsuccessclass'] . '"',
                    'alerterrorclass' => '"' . $data['alerterrorclass'] . '"',
                    'alertcommonclass' => '"' . $data['alertcommonclass'] . '"',
                    'alertdisplaytimeok' => $data['alertdisplaytimeok'],
                    'alertdisplaytimefalse' => $data['alertdisplaytimefalse'],
                    'resultok' => '"' . $this->translateOrPrint($data['resultok']) . '"',
                    'resultfalse' => '"' . $this->translateOrPrint($data['resultfalse']) . '"',
                    'tokenexpired' => '"' . $this->translateOrPrint($data['tokenexpired']) . '"',
                    'buttondivclass' => '"' . $data['buttondivclass'] . '"',
                    'submitbtnclass' => '"' . $data['submitbtnclass'] . '"',
                    'additionalbuttons' => $btns,
                    'submitbtnlbl' => '"' . $this->translateOrPrint($data['submitbtnlbl']) . '"',
                    'evalajaxres_callback' => is_null($data['evalajaxres_callback']) ? 'null' : $data['evalajaxres_callback'],
                    'evalajaxres_resultmessage' => is_null($data['evalajaxres_resultmessage']) ? 'null' : $data['evalajaxres_resultmessage'],
                    'resetvalues' => $resetvalues
                ],
                '});' => null
            ],
            '});' => null
        ]);
        /* $output .= '<script>' . PHP_EOL;
          $output .= '  jQuery(document).ready(function() {' . PHP_EOL;
          $output .= '    jQuery("#' . $values["id"] . '").sebFormHelper({' . PHP_EOL;
          $output .= '      validate : ' . $data['validate'] ? 'true' : 'false' . ',' . PHP_EOL;
          $output .= '      checkonleave : ' . $data['checkonleave'] ? 'true' : 'false' . ',' . PHP_EOL;
          $output .= '      ajaxcallback : ' . is_null($data['ajaxcallback']) ? 'null' : $data['ajaxcallback'] . ',' . PHP_EOL;
          $output .= '      filldatacallback : ' . is_null($data['filldatacallback']) ? 'null' : $data['filldatacallback'] . ',' . PHP_EOL;
          $output .= '      requiredclass : "' . $data['requiredclass'] . '",' . PHP_EOL;
          $output .= '      requiredcheckclass : "' . $data['requiredcheckclass'] . '",' . PHP_EOL;
          $output .= '      selcheckclass : "' . $data['selcheckclass'] . '",' . PHP_EOL;
          $output .= '      requiredspecialclass : "' . $data['requiredspecialclass'] . '",' . PHP_EOL;
          $output .= '      verifymailclass : "' . $data['verifymailclass'] . '",' . PHP_EOL;
          $output .= '      verifypassclass : "' . $data['verifypassclass'] . '",' . PHP_EOL;
          $output .= '      verifypassmatchclass : "' . $data['verifypassmatchclass'] . '",' . PHP_EOL;
          $output .= '      verifypassold : "' . $data['verifypassold'] . '",' . PHP_EOL;
          $output .= '      resettextclass : "' . $data['resettextclass'] . '",' . PHP_EOL;
          $output .= '      resetselectclass : "' . $data['resetselectclass'] . '",' . PHP_EOL;
          $output .= '      resetcheckclass : "' . $data['resetcheckclass'] . '",' . PHP_EOL;
          $output .= '      resetradioclass : "' . $data['resetradioclass'] . '",' . PHP_EOL;
          $output .= '      resetspecialclass: "' . $data['resetspecialclass'] . '",' . PHP_EOL;
          $output .= '      data_build_function : ' . (is_null($data['data_build_function']) ?
          'null,' . PHP_EOL : '"' . $data['data_build_function'] . '",' . PHP_EOL);
          $output .= '      remove_validation_function : ' . (is_null($data['remove_validation_function']) ?
          'null,' . PHP_EOL : '"' . $data['remove_validation_function'] . '",' . PHP_EOL);
          $output .= '      clearonclick_function : ' . is_null($data['clearonclick_function']) ? 'null' : $data['clearonclick_function'] . ',' . PHP_EOL;
          $output .= '      validate_function : ' . is_null($data['validate_function']) ? 'null' : $data['validate_function'] . ',' . PHP_EOL;
          $output .= '      clear_function : ' . is_null($data['clear_function']) ? 'null' : $data['clear_function'] . ',' . PHP_EOL;
          $output .= '      csrf : "' . $data['csrf'] . '",' . PHP_EOL;
          $output .= '      check_modified_on_reset : ' . $data['check_modified_on_reset'] ? 'true' : 'false' . ',' . PHP_EOL;
          $output .= '      modified_on_reset_confirm_text : "' . $this->translateOrPrint($data['modified_on_reset_confirm_text']) . '",' . PHP_EOL;
          $output .= '      buildbuttons: ' . $data['buildbuttons'] ? 'true' : 'false' . ',' . PHP_EOL;
          $output .= '      buildresultalert: ' . $data['buildresultalert'] ? 'true' : 'false' . ',' . PHP_EOL;
          $output .= '      alertsuccessclass: "' . $data['alertsuccessclass'] . '",' . PHP_EOL;
          $output .= '      alerterrorclass: "' . $data['alerterrorclass'] . '",' . PHP_EOL;
          $output .= '      alertcommonclass : "' . $data['alertcommonclass'] . '",' . PHP_EOL;
          $output .= '      alertdisplaytimeok : ' . $data['alertdisplaytimeok'] . ',' . PHP_EOL;
          $output .= '      alertdisplaytimefalse : ' . $data['alertdisplaytimefalse'] . ',' . PHP_EOL;
          $output .= '      resultok : "' . $this->translateOrPrint($data['resultok']) . '",' . PHP_EOL;
          $output .= '      resultfalse : "' . $this->translateOrPrint($data['resultfalse']) . '",' . PHP_EOL;
          $output .= '      tokenexpired : "' . $this->translateOrPrint($data['tokenexpired']) . '",' . PHP_EOL;
          $output .= '      buttondivclass : "' . $data['buttondivclass'] . '",' . PHP_EOL;
          $output .= '      submitbtnclass : "' . $data['submitbtnclass'] . '",' . PHP_EOL;
          $output .= '      additionalbuttons : ' . $btns . ',' . PHP_EOL;
          $output .= '      submitbtnlbl : "' . $this->translateOrPrint($data['submitbtnlbl']) . '",' . PHP_EOL;
          $output .= '      evalajaxres_callback: ' . is_null($data['evalajaxres_callback']) ? 'null' : $data['evalajaxres_callback'] . ',' . PHP_EOL;
          $output .= '      evalajaxres_resultmessage: ' . is_null($data['evalajaxres_resultmessage']) ? 'null' : $data['evalajaxres_resultmessage'] . ',' . PHP_EOL;
          $output .= '      resetvalues: ' . $resetvalues . PHP_EOL;
          $output .= '    });' . PHP_EOL;
          $output .= '  });' . PHP_EOL;
          $output .= '</script>' . PHP_EOL; */
        return $output;
    }

    public function bsHidden($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.hidden'), $data);
        $data = $this->mergeValues(config('formsbootstrap.defaults.hidden'), $data);
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        $attributes = array_merge(['id' => $data['id']], $data['attributes']);
        return $this->buildInput('hidden', $data['name'], $data['value'], $attributes);
    }

    public function bsText($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.text'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.text'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $data['labeltext'],
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildInput(
                        'text',
                        $data['name'],
                        $data['value'],
                        array_merge(['id' => $data['id'],
                    'class' => $data['inputclass']], $data['attributes'])
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
    }

    public function bsNumber($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.number'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.number'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        if (!is_null($data['value'])) {
            $data['attributes']['placeholder'] = $data['value'];
        }
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $data['labeltext'],
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildInput(
                        'number',
                        $data['name'],
                        $data['value'],
                        array_merge(
                                ['id' => $data['id'],
                                    'class' => $data['inputclass']],
                                $data['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
    }

    public function bsRange($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.range'), $data);
        $data = $this->mergeValues(
                array_merge(config('formsbootstrap.defaults.range'), config('formsbootstrap.classes')),
                $data
        );
        if (!is_null($data['value'])) {
            $data['placeholder'] = $data['value'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        $attributes = [];
        if (!is_null($data['min'])) {
            $attributes['min'] = $data['min'];
        }
        if (!is_null($data['max'])) {
            $attributes['max'] = $data['max'];
        }
        if (!is_null($data['step'])) {
            $attributes['step'] = $data['step'];
        }
        if (!is_null($data['placeholder'])) {
            $attributes['placeholder'] = $data['placeholder'];
        }
        $output = $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $data['labeltext'],
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
        );
        if ($data['showvalue'] || $data['show_bounds']) {
            $output .= '<div class="' . $data['groupclass'] . '">' . PHP_EOL;
            if (!is_null($data['min']) && $data['show_bounds']) {
                $output .= '<span class="' . $data['groupeltclass'] . '">' . $data['min'] . '</span>' . PHP_EOL;
            }
            $output .= $this->buildInput(
                    'range',
                    $data['name'],
                    $data['value'],
                    array_merge(
                            ['id' => $data['id'],
                                'class' => $data['inputclass']],
                            $attributes
                    )
            );
            if (!is_null($data['max']) && $data['show_bounds']) {
                $output .= '<span class="' . $data['groupeltclass'] . '">' . $data['max'] . '</span>' . PHP_EOL;
            }
            if ($data['showvalue']) {
                $output .= '<span class="' . $data['groupeltresclass'] . '">' .
                        $this->translateOrPrint($data['valueprefix']) . ':&nbsp;<span id="' .
                        $data['id'] . '_val"></span></span>' . PHP_EOL;
            }
            $output .= '</div>' . PHP_EOL;
        } else {
            $output .= $this->buildInput(
                    'range',
                    $data['name'],
                    $data['value'],
                    array_merge(
                            ['id' => $data['id'],
                                'class' => $data['inputclass']],
                            $attributes
                    )
            );
        }
        $output .= $this->buildEndDiv($data['input_in_div']);
        if ($data['showvalue']) {
            $output .= $this->buildJsCode([
                'jQuery("#' . $data['id'] . '").on("input", function(){' => [
                    'jQuery("#' . $data['id'] . '_val").html(jQuery("#' . $data['id'] . '").val())' => null
                ],
                '});' => null,
                'jQuery("#' . $data['id'] . '_val").html(jQuery("#' . $data['id'] . '").val())' => null
            ]);
        }
        return $output;
    }

    public function bsTextarea($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.textarea'), $data);
        $data = $this->mergeValues(
                array_merge(config('formsbootstrap.defaults.textarea'), config('formsbootstrap.classes')),
                $data
        );
        if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $data['labeltext'],
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildTextarea(
                        $data['name'],
                        $data['value'],
                        array_merge(
                                ['id' => $data['id'],
                                    'class' => $data['inputclass']],
                                $data['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
    }

    public function bsEmail($data = []) {
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.email'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        if ($data['verify']) {
            $data['inputclass'] .= ' ' . $data['verifymailclass'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        $output = $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $this->translateOrPrint($data['labeltext']),
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildInput(
                        'email',
                        $data['name'],
                        $data['value'],
                        array_merge(
                                ['id' => $data['id'],
                                    'class' => $data['inputclass']],
                                $data['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
        if ($data['verify']) {
            $output .= $this->buildJsCode([
                'jQuery("#' . $data['id'] . '").sebEmailHelper({emailregex : ' . $data['regex'] . '});' => null
            ]);
        }
        return $output;
    }

    public function bsPassword($data = []) {
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.password'),
                        config('formsbootstrap.defaults.password_common'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if ($data['validate']) {
            $data['inputclass'] .= ' ' . $data['verifypassclass'];
        } else if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        $data['inputclass'] .= ' ' . $data['resettextclass'];
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $this->translateOrPrint($data['labeltext']),
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildInput(
                        'password',
                        $data['name'],
                        '',
                        array_merge(
                                ['id' => $data['id'],
                                    'class' => $data['inputclass']],
                                $data['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), ($data['required'] || $data['validate']), ($data['required'] || $data['validate'])) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']) .
                $this->buildJsCode([
                    'jQuery("#' . $data['id'] . '").sebPasswordHelper({passregex : ' . $data['password_regex'] . '});' => null
                ]);
    }

    public function bsPasswordWithConfirm($data = []) {
        $data = $this->mergeValues(array_merge(
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
        if (count($data['password_rules_list']) == 0) {
            $passrules = $this->complileRules();
        } else {
            $passrules = $data['password_rules_list'];
        }
        $data['oldpass']['inputclass'] .= ' ' . $data['resettextclass'];
        $data['newpass']['inputclass'] .= ' ' . $data['resettextclass'];
        $data['confirmpass']['inputclass'] .= ' ' . $data['resettextclass'];
        $data['oldpass']['attributes']['data-maininput'] = '#' . $data['newpass']['id'];
        $data['confirmpass']['attributes']['data-maininput'] = '#' . $data['newpass']['id'];
        $output = '';
        if ($data['show_old']) {
            $output .= $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['oldpass']['id']);
            $output .= $this->buildLabel(
                            $data['oldpass']['id'],
                            $this->translateOrPrint($data['oldpass']['labeltext']),
                            array_merge(['class' => $data['oldpass']['labelclass']], $data['oldpass']['labelattributes'])
                    ) .
                    $this->buildInput(
                            'password',
                            $data['oldpass']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['oldpass']['id'],
                                        'class' => $data['oldpass']['inputclass']],
                                    $data['oldpass']['attributes']
                            )
                    ) .
                    $this->buildFeedbacks($data['oldpass-validfeedback'], $this->translateOrPrint($data['oldpass-feedback']), true, true) .
                    $this->buildEndDiv($data['input_in_div']);
        }
        $output .= $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['newpass']['id']) .
                $this->buildLabel(
                        $data['newpass']['id'],
                        $this->translateOrPrint($data['newpass']['labeltext']),
                        array_merge(['class' => $data['newpass']['labelclass']], $data['newpass']['labelattributes'])
        );
        if ($data['show_generate']) {
            $output .= $this->buildStartDiv(true, $data['pwdbtngroup-class'] . ' ' . $data['newpass']['id'] . '-div', $data['pwdhiddenzone-id']) .
                    $this->buildInput(
                            'password',
                            $data['newpass']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['newpass']['id'],
                                        'class' => $data['newpass']['inputclass']],
                                    $data['newpass']['attributes']
                            )
                    ) .
                    $this->buildButton($data['togglebtn-class'] . ' ' . $data['newpass']['id'] . "-btn", $data['toggledbtn-icon-on'], [
                        'title' => $this->translateOrPrint($data['toggledbtn-title'])
                    ]) .
                    $this->buildButton($data['generatepwdbtn-class'] . ' ' . $data['newpass']['id'] . "-gen", $data['generatebtn-icon'], [
                        'title' => $this->translateOrPrint($data['showrulesbtntext'])
            ]);

            if ($data['show_rules']) {
                $output .= $this->buildButton($data['generatepwdbtn-class'], '<i class="fa-solid fa-ruler"></i>', [
                    'title' => $this->translateOrPrint($data['generatepwdbtn-title']),
                    'data-bs-toggle' => "modal",
                    'data-bs-target' => "#" . $data['newpass']['id'] . "-rule-modal"
                ]);
            }
            $output .= $this->buildFeedbacks($this->translateOrPrint($data['valid-feedback']), $this->translateOrPrint($data['invalid-feedback']), true, true) .
                    $this->buildEndDiv(true) .
                    $this->buildStartDiv(true, $data['pwdbtngroup-class'] . ' ' . $data['newpass']['id'] . '-div', $data['pwdclearzone-id'], [
                        'style' => "display:none"
                    ]) .
                    $this->buildInput(
                            'text',
                            $data['newpassclear']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['newpassclear']['id'],
                                        'class' => $data['newpassclear']['inputclass']],
                                    $data['newpassclear']['attributes']
                            )
                    ) .
                    $this->buildButton($data['togglebtn-class'] . ' ' . $data['newpass']['id'] . "-btn", $data['toggledbtn-icon-off'], [
                        'title' => $this->translateOrPrint($data['toggledbtn-title'])
                    ]) .
                    $this->buildButton($data['generatepwdbtn-class'] . ' ' . $data['newpass']['id'] . "-gen", $data['generatebtn-icon'], [
                        'title' => $this->translateOrPrint($data['generatepwdbtn-title'])
                    ]);

            if ($data['show_rules']) {
                $output .= $this->buildButton($data['generatepwdbtn-class'], '<i class="fa-solid fa-ruler"></i>', [
                    'title' => $this->translateOrPrint($data['showrulesbtntext']),
                    'data-bs-toggle' => "modal",
                    'data-bs-target' => "#" . $data['newpass']['id'] . "-rule-modal"
                ]);
            }
            $output .= $this->buildEndDiv(true);
        } else if ($data['show_clear']) {
            $output .= $this->buildStartDiv(true, $data['pwdbtngroup-class'] . ' ' . $data['newpass']['id'] . '-div', $data['pwdhiddenzone-id']) .
                    $this->buildInput(
                            'password',
                            $data['newpass']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['newpass']['id'],
                                        'class' => $data['newpass']['inputclass']],
                                    $data['newpass']['attributes']
                            )
                    ) .
                    $this->buildSimpleDiv($data['pwdbtn-class']) .
                    $this->buildButton($data['togglebtn-class'] . ' ' . $data['newpass']['id'] . "-btn", $data['toggledbtn-icon-off'], [
                        'title' => $this->translateOrPrint($data['toggledbtn-title'])
            ]);
            if ($data['show_rules']) {
                $output .= $this->buildButton($data['generatepwdbtn-class'], '<i class="fa-solid fa-ruler"></i>', [
                    'title' => $this->translateOrPrint($data['generatepwdbtn-title']),
                    'data-bs-toggle' => "modal",
                    'data-bs-target' => "#" . $data['newpass']['id'] . "-rule-modal",
                    'action' => "return false"
                ]);
            }
            $output .= $this->buildEndDiv(true)
                    . $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, true)
                    . $this->buildEndDiv(true)
                    . $this->buildStartDiv(true, $data['pwdbtngroup-class'] . ' ' . $data['newpass']['id'] . '-div', $data['pwdclearzone-id'], [
                        'style' => "display:none"
                    ])
                    . $this->buildInput(
                            'text',
                            $data['newpassclear']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['newpassclear']['id'],
                                        'class' => $data['newpassclear']['inputclass']],
                                    $data['newpassclear']['attributes']
                            )
                    )
                    . $this->buildSimpleDiv($data['pwdbtn-class'])
                    . $this->buildButton($data['togglebtn-class'] . ' ' . $data['newpass']['id'] . "-btn", $data['toggledbtn-icon-off'], [
                        'title' => $this->translateOrPrint($data['toggledbtn-title'])
                    ]);
        } else {
            $output .= $this->buildInput(
                            'password',
                            $data['newpass']['name'],
                            '',
                            array_merge(
                                    ['id' => $data['newpass']['id'],
                                        'class' => $data['newpass']['inputclass']],
                                    $data['newpass']['attributes']
                            )
                    ) . $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, true);
        }
        $output .= $this->buildEndDiv($data['input_in_div']);
        if ($data['show_rules']) {
            $output .= $this->buildStartDiv(true, "modal fade", $data['newpass']['id'] . '-rule-modal', [
                        'tabindex' => "-1",
                        'aria-labelledby' => $data['newpass']['id'] . '-rule-label',
                        'aria-hidden' => "true"
                    ]) .
                    $this->buildSimpleDiv("modal-dialog") .
                    $this->buildSimpleDiv("modal-content") .
                    $this->buildSimpleDiv("modal-header") .
                    '<h5 class="modal-title" id="' . $data['newpass']['id'] . '-rule-label">' . $this->translateOrPrint($data['password_rules_modal_head']) . '</h5>' . PHP_EOL .
                    $this->buildButton("btn-close", '', [
                        'data-bs-dismiss' => "modal",
                        "aria-label" => $this->translateOrPrint($data['close_rules']),
                        "title" => $this->translateOrPrint($data['close_rules'])
                    ]) .
                    $this->buildEndDiv(true) .
                    $this->buildSimpleDiv("modal-body") .
                    '<p>' . $this->translateOrPrint($data['password_rules_intro']) . '</p>' . PHP_EOL . '<ul>' . PHP_EOL;
            foreach ($passrules as $rule) {
                $output .= '<li>' . $rule . '</li>' . PHP_EOL;
            }
            $output .= '</ul>' . PHP_EOL .
                    $this->buildEndDiv(true) .
                    $this->buildEndDiv(true) .
                    $this->buildEndDiv(true);
        }
        $output .= $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['confirmpass']['id']) .
                $this->buildLabel(
                        $data['confirmpass']['id'],
                        $this->translateOrPrint($data['confirmpass']['labeltext']),
                        array_merge(['class' => $data['confirmpass']['labelclass']], $data['confirmpass']['labelattributes'])
                ) .
                $this->buildInput(
                        'password',
                        $data['confirmpass']['name'],
                        '',
                        array_merge(
                                ['id' => $data['confirmpass']['id'],
                                    'class' => $data['confirmpass']['inputclass']],
                                $data['confirmpass']['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['nomatch-validfeedback'], $this->translateOrPrint($data['nomatch-feedback']), true, true) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
        if ($data['show_generate'] || $data['show_clear']) {
            $passparams = [
                'passregex' => $data['password_regex'],
                'passchars' => '"' . addslashes($data['password_chars']) . '"',
                'genlength' => $data["generated_pass_length"],
                'confirminput' => '"#' . $data['confirmpass']['id'] . '"',
                'clearinput' => '"#' . $data['newpassclear']['id'] . '"'
            ];
            if ($data['show_old']) {
                $passparams = array_merge($passparams, [
                    'oldinput' => '"#' . $data['oldpass']['id'] . '"',
                    'checkoldpassurl' => is_null($data['checkoldpassurl']) ? 'null' : '"' . $data['checkoldpassurl'] . '"',
                    'checkoldpass_callback' => is_null($data['checkoldpass_callback']) ? 'null' : $data['checkoldpass_callback'],
                    'csrf' => '"' . $data['csrf'] . '"'
                ]);
            }
            $output .= $this->buildJsCode([
                'jQuery(document).ready(function() {' => [
                    'jQuery("#' . $data['newpass']['id'] . '").sebPasswordHelper({' => $passparams,
                    '});' => null
                ],
                '});' => null
            ]);
        }
        return $output;
    }

    public function bsSelect($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.select'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.select'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if ($data['required']) {
            $data['inputclass'] .= ' ' . $data['requiredclass'];
        }
        $data['inputclass'] .= ' ' . $data['resetselectclass'];
        if ($data['multiple']) {
            if (preg_match('/^(\w+)\[\]$/', $data['name'], $m) > 0) {
                $data['id'] = $m[1];
                $data['attributes'] = array_merge(['multiple' => 'multiple', 'id' => $data['id']], $data['attributes']);
            } else {
                $data['id'] = $data['name'];
                $data['attributes'] = array_merge(['multiple' => 'multiple', 'id' => $data['id']], $data['attributes']);
                $data['name'] .= '[]';
            }
        } else {
            $data['id'] = $data['name'];
        }
        $data['default'] = explode(',', $data['default']);
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $data['labeltext'],
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildSelect(
                        $data['name'],
                        $data['values'],
                        $data['default'],
                        array_merge(
                                ['id' => $data['id'],
                                    'class' => $data['inputclass']],
                                $data['attributes']
                        )
                ) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), $data['feedback'], $data['feedback']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']);
    }

    public function bsCheckbox($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.checkbox'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.checkbox'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if (preg_match('/^(\w+)\[\]$/', $data['name'], $m) > 0) {
            $data['id'] = $m[1];
        } else {
            $data['id'] = $data['name'];
            $data['name'] .= '[]';
        }
        if ($data['switch']) {
            $data['divelt'] .= ' ' . $data['switch-class'];
            $data['attributes']['role'] = 'switch';
        }
        if ($data['required']) {
            $data['divelt'] .= ' ' . $data['requiredcheckclass'];
            $data['divclass'] .= ' ' . $data['selcheckclass'];
        }
        $data['divclass'] .= ' ' . $data['resetcheckclass'];
        $output = $this->buildStartDiv(true, $data['divclass'], 'fg-' . $data['name'], $data['mainattr']);
        if (strlen($data['mainlabel']) > 0) {
            $output .= $this->buildLabel('', $data['mainlabel'], ['class' => $data['mainlabelclass']]);
        }
        foreach ($data['values'] as $key => $value) {
            if (is_array($data['checkedvalues'])) {
                if (in_array($key, $data['checkedvalues'])) {
                    $additional = [
                        'checked' => "checked",
                        'defaultchecked' => "defaultchecked"
                    ];
                }
            } else if ($data['checkedvalues'] == $key) {
                $additional = [
                    'checked' => "checked",
                    'defaultchecked' => "defaultchecked"
                ];
            } else {
                $additional = [];
            }
            $output .= $this->buildSimpleDiv($data['divelt']) .
                    $this->buildInput(
                            'checkbox',
                            $data['name'],
                            $value,
                            array_merge(
                                    ['id' => $data['id'] . '_' . $key,
                                        'class' => $data['inputclass']],
                                    $data['attributes'],
                                    $additional
                            )
                    ) .
                    $this->buildLabel(
                            $data['id'] . '_' . $key,
                            $value,
                            array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                    ) .
                    $this->buildEndDiv(true);
        }
        $output .= $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv(true);
        return $output;
    }

    public function bsRadio($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.radio'), $data);
        $data = $this->mergeValues(
                array_merge(
                        config('formsbootstrap.defaults.radio'),
                        config('formsbootstrap.classes')
                ), $data
        );
        if (preg_match('/^(\w+)\[\]$/', $data['name'], $m) > 0) {
            $data['id'] = $m[1];
        } else {
            $data['id'] = $data['name'];
            $data['name'] .= '[]';
        }
        if ($data['required']) {
            $data['divelt'] .= ' ' . $data['requiredcheckclass'];
            $data['divclass'] .= ' ' . $data['selcheckclass'];
        }
        $data['divclass'] .= ' ' . $data['resetcheckclass'];
        $output = $this->buildStartDiv(true, $data['divclass'], 'fg-' . $data['name'], $data['mainattr']);
        if (strlen($data['mainlabel']) > 0) {
            $output .= $this->buildLabel('', $data['mainlabel'], ['class' => $data['mainlabelclass']]);
        }
        foreach ($data['values'] as $key => $value) {
            if ($data['checkedvalue'] == $key) {
                $additional = [
                    'checked' => "checked",
                    'defaultchecked' => "defaultchecked"
                ];
            } else {
                $additional = [];
            }
            $output .= $this->buildSimpleDiv($data['divelt']) .
                    $this->buildInput(
                            'radio',
                            $data['name'],
                            $value,
                            array_merge(
                                    [
                                        'id' => $data['id'] . '_' . $key,
                                        'class' => $data['inputclass']
                                    ],
                                    $data['attributes'],
                                    $additional
                            )
                    ) .
                    $this->buildLabel(
                            $data['id'] . '_' . $key,
                            $value,
                            array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                    ) .
                    $this->buildEndDiv(true);
        }
        $output .= $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), true, $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv(true);
        return $output;
    }

    public function bsSubmit($data) {
        $data = $this->mergeValues(config('formsbootstrap.defaults.submit'), $data);
        return $this->buildButton(
                        $data['class'],
                        $this->translateOrPrint($data['label']),
                        array_merge(['id' => $data['id']], $data['attributes']),
                        'submit'
        );
    }

    public function bsButton($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.button'), $data);
        $data = $this->mergeValues(config('formsbootstrap.defaults.button'), $data);
        $output = $this->buildButton(
                $data['class'],
                $data['label'],
                array_merge(['id' => $data['id']], $data['attributes'])
        );
        if ($data['action'] != null) {
            $output .= $this->buildJsCode([
                'jQuery("#' . $data['id'] . '").on("click", function(e){ ' . $data['action'] . ' });' => null
            ]);
        }
        return $output;
    }

    public function bsColorpicker($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.colorpicker'), $data);
        $data = $this->mergeValues(config('formsbootstrap.defaults.colorpicker'), $data);
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name'], $data['mainattr']) .
                $this->buildLabel(
                        $data['id'],
                        $this->translateOrPrint($data['labeltext']),
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildInput(
                        'color',
                        $data['name'],
                        $data['value'],
                        array_merge(
                                [
                                    'id' => $data['id'],
                                    'class' => $data['inputclass'],
                                    'title' => $this->translateOrPrint($data['title'])
                                ],
                                $data['attributes']
                        )
                ) .
                $this->buildEndDiv($data['input_in_div']);
    }

    public function bsEditor($data) {
        $this->checkMandatory(config('formsbootstrap.mandatory.editor'), $data);
        $data = $this->mergeValues(array_merge(config('formsbootstrap.defaults.editor'), config('formsbootstrap.classes')), $data);
        if ($data['required']) {
            $data['divclass'] .= ' ' . $data['requiredspecialclass'];
        }
        if ($data['addresetclass']) {
            $data['divclass'] .= ' ' . $data['resetspecialclass'];
        }
        if (isset($data['value']) && strlen($data['value'])) {
            $text = addslashes(s($data['value'])->collapseWhitespace());
        } else {
            $text = '';
        }
        if (!isset($data['name']) || strlen($data['name']) == 0) {
            $data['name'] = $data['id'];
        }
        if (!is_null($data['configvar'])){
            $jscode = [
                'jQuery("#' . $data["id"] . '").sebRichTextHelper(' . $data['configvar'] . ');' => null
            ];
        }elseif (!is_null($data['config'])){
            $jscode = [
                'jQuery("#' . $data["id"] . '").sebRichTextHelper(' . 
                $this->validateEditorParams($data['config'], $data['translations']) 
                . ');' => null
            ];
        } else{
            $jscode = ['jQuery("#' . $data["id"] . '").sebRichTextHelper();' => null];
        }
        /*if (strlen($text) > 0){
            $jscode = array_merge(
                $jscode, 
                [
                    'jQuery("#' . $data["id"] . '").data("sebrichtexthelper").loadContent("' . $text . '");' => null
                ]
            );
        }*/
        return $this->buildStartDiv($data['input_in_div'], $data['divclass'], 'fg-' . $data['name']) .
                $this->buildLabel(
                        $data['id'],
                        $this->translateOrPrint($data['labeltext']),
                        array_merge(['class' => $data['labelclass']], $data['labelattributes'])
                ) .
                $this->buildTextarea($data['name'], '', array_merge([
                    'id' => $data['id']. '-input'], 
                     $data['attributes']
                )) .
                $this->buildFeedbacks($data['valid-feedback'], $this->translateOrPrint($data['invalid-feedback']), $data['required'], $data['required']) .
                $this->buildHelp($data) .
                $this->buildEndDiv($data['input_in_div']) . 
                $this->buildJsCode($jscode);
    }

    public function bsClose() {
        return '</form>' . PHP_EOL;
    }

    private function buildInput($type, $name, $value, $attributes) {
        $output = '<input type="' . $type . '" name="' . $name . '" value="' . $value . '"';
        foreach ($attributes as $key => $val) {
            if (is_null($val)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $val . '"';
            }
        }
        $output .= ' />' . PHP_EOL;
        return $output;
    }

    private function buildTextarea($name, $value, $attributes) {
        $output = '<textarea name="' . $name . '"';
        foreach ($attributes as $key => $val) {
            if (is_null($val)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $val . '"';
            }
        }
        $output .= '>' . PHP_EOL;
        $value = s($value)->trim();
        if (s($value)->length() > 0) {
            $output .= $value . PHP_EOL;
        }
        $output .= '</textarea>' . PHP_EOL;
        return $output;
    }

    private function buildSelect($name, $values, $default, $attributes) {
        $output = '<select name="' . $name . '"';
        foreach ($attributes as $key => $val) {
            if (is_null($val)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $val . '"';
            }
        }
        $output .= '>' . PHP_EOL;
        foreach ($values as $key => $val) {
            $output .= '<option value="' . $key . '"';
            if (in_array($val, $default)) {
                $output .= ' defaultchecked="defaultchecked" selected="selected"';
            }
            $output .= '>' . $val . '</option>' . PHP_EOL;
        }
        $output .= '</select>' . PHP_EOL;
        return $output;
    }

    private function buildLabel($name, $label, $attributes) {
        $output = '<label for="' . $name . '"';
        foreach ($attributes as $key => $value) {
            if (is_null($value)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $value . '"';
            }
        }
        $output .= '>' . $label . '</label>' . PHP_EOL;
        return $output;
    }

    private function buildStartDiv($display, $divclass, $id, $attrs = []) {
        $output = '';
        if ($display) {
            $output .= '<div class="' . $divclass . '" id="' . $id . '"';
            if (count($attrs) > 0) {
                foreach ($attrs as $key => $value) {
                    if (is_null($value)) {
                        $output .= ' ' . $key;
                    } else {
                        $output .= ' ' . $key . '="' . $value . '"';
                    }
                }
            }
            $output .= '>' . PHP_EOL;
        }
        return $output;
    }

    private function buildSimpleDiv($divclass) {
        return '<div class="' . $divclass . '">' . PHP_EOL;
    }

    private function buildEndDiv($display) {
        $output = '';
        if ($display) {
            $output .= '</div>' . PHP_EOL;
        }
        return $output;
    }

    private function buildFeedbacks($valid_feedback, $invalid_feedback, $checkvalid, $checkinvalid) {
        $output = '';
        if ($checkvalid && strlen($valid_feedback) > 0) {
            $output .= '<div class="valid-feedback">' . $valid_feedback . '</div>' . PHP_EOL;
        }
        if ($checkinvalid && strlen($invalid_feedback) > 0) {
            $output .= '<div class="invalid-feedback">' . $invalid_feedback . '</div>' . PHP_EOL;
        }

        return $output;
    }

    private function buildHelp($data) {
        $output = '';
        if (strlen($data['helptext']) > 0) {
            $output .= '<p class="help-block">' . $data['helptext'] . '</p>' . PHP_EOL;
        }
        return $output;
    }

    private function buildButton($buttonclass, $buttoncontent, $params = [], $type = 'button') {
        $output = '<button type="' . $type . '" class="' . $buttonclass . '"';
        foreach ($params as $key => $value) {
            if (is_null($value)) {
                $output .= ' ' . $key;
            } else {
                $output .= ' ' . $key . '="' . $value . '"';
            }
        }
        $output .= '>' . $buttoncontent . '</button>' . PHP_EOL;
        return $output;
    }

    private function _printTabs($depth) {
        $tabs = '';
        for ($i = 0; $i <= $depth; $i++) {
            $tabs .= '  ';
        }
        return $tabs;
    }

    private function _printJsCode($code, &$depth) {
        $depth++;
        $output = '';
        if (count($code) > 0){
            foreach ($code as $left => $right) {
                if (is_array($right)) {
                    $output .= $this->_printTabs($depth) . $left . PHP_EOL . $this->_printJsCode($right, $depth);
                } elseif (is_null($right)) {
                    $output .= $this->_printTabs($depth) . $left . PHP_EOL;
                } else {
                    $output .= $this->_printTabs($depth) . $left . ' : ' . $right . ',' . PHP_EOL;
                }
            }
        }
        $depth--;
        return $output;
    }

    private function buildJsCode($code = []) {
        $output = '<script>' . PHP_EOL;
        $depth = 0;
        $output .= $this->_printJsCode($code, $depth);
        $output .= '</script>' . PHP_EOL;
        return $output;
    }

    private function checkMandatory($mandatory, $data) {
        foreach ($mandatory as $param) {
            if (!isset($data[$param])) {
                throw new \Exception('missing mandatory parameter ' . $param);
            }
        }
    }

    /**
     * translate key between ## or returns unchanged key
     * @param  string $key key to translate
     * @return string      translated key
     */
    private function translateOrPrint($key) {
        if (preg_match('/^\#(.+)\#$/', $key, $matches)) {
            return addslashes(__($matches[1]));
        }
        return $key;
    }

    /**
     * recursively updates parameters with new values.
     * @param  array $defaults  orignal mutlidimensional values
     * @param  array $newValues values to replace
     * @return array            merge results
     */
    private function mergeValues($defaults, $newValues) {
        if (count($newValues) > 0) {
            foreach ($newValues as $key => $value) {
                if (is_array($value)) {
                    if (!isset($defaults[$key]))
                        $defaults[$key] = [];
                    $defaults[$key] = $this->mergeValues($defaults[$key], $value);
                } else {
                    $defaults[$key] = $value;
                }
            }
        }
        return $defaults;
    }

    private function complileRules() {
        return [
            sprintf(
                    __('formsbootstrap::messages.password_rule_length'),
                    config('formsbootstrap.defaults.password_common.min_password'),
                    config('formsbootstrap.defaults.password_common.max_password')
            ),
            __('formsbootstrap::messages.password_rule_case'),
            __('formsbootstrap::messages.password_rule_number'),
            sprintf(
                    __('formsbootstrap::messages.password_rule_special_char'),
                    config('formsbootstrap.defaults.password_common.authorized_special_chars')
            ),
        ];
    }

    private function validateEditorParams($params = null, $addTranslations = null) {
        if (!is_array($params) && !is_null($params)) {
            throw new \Exception('no array');
        }
        if (is_null($params)) {
            $params = config('formsbootstrap.defaults.editor.config');
        }
        $stringarray = function ($attribute, $a, $fail) {
            foreach ($a as $v){
                if (!is_string($v)) {
                    $fail('array must contain strings');
                }
            }
        };
        $validator = Validator::make($params, [
            'bold' => 'boolean',
            'italic' => 'boolean',
            'underline' => 'boolean',
            'leftAlign' => 'boolean',
            'centerAlign' => 'boolean',
            `rightAlign` => 'boolean',
            `justify` => 'boolean',
            `ol` => 'boolean',
            'ul' => 'boolean',
            'heading' => 'boolean',
            'fonts' => 'boolean',
            'fontList' => [
                'array',
                $stringarray
            ],
            'fontColor' => 'boolean',
            'fontSize' => 'boolean',
            'imageUpload' => 'boolean',
            'fileUpload' => 'boolean',
            'videoEmbed' => 'boolean',
            'urls' => 'boolean',
            'table' => 'boolean',
            'removeStyles' => 'boolean',
            'code' => 'boolean',
            'colors' => [
                'array',
                $stringarray
            ],
            'fileHTML' => 'string',
            'imageHTML' => 'string',
            'youtubeCookies' => 'boolean',
            'useSingleQuotes' => 'boolean',
            'height' => 'integer',
            'heightPercentage' => 'integer',
            'id' => "string",
            'class' => "string",
            'useParagraph' => 'boolean',
            'maxlength' => 'integer',
            'callback' => 'string',
            'useTabForNext' => 'boolean'
        ]);
        $defaults = [
            // text formatting
            `bold` => true,
            'italic' => true,
            'underline' => true,
            // text alignment
            'leftAlign' => true,
            'centerAlign' => true,
            `rightAlign` => true,
            `justify` => true,
            // lists
            `ol` => true,
            'ul' => true,
            // title
            'heading' => true,
            // fonts
            'fonts' => true,
            'fontList' => [
                "Arial",
                "Arial Black",
                "Comic Sans MS",
                "Courier New",
                "Geneva",
                "Georgia",
                "Helvetica",
                "Impact",
                "Lucida Console",
                "Tahoma",
                "Times New Roman",
                "Verdana"
            ],
            'fontColor' => true,
            'fontSize' => true,
            // uploads
            // better use https://github.com/seblhaire/uploader
            'imageUpload' => true,
            'fileUpload' => true,
            // media
            'videoEmbed' => true,
            // link
            'urls' => true,
            // tables
            'table' => true,
            // code
            'removeStyles' => true,
            'code' => true,
            // colors
            'colors' => [],
            // dropdowns
            'fileHTML' => '',
            'imageHTML' => '',
            // privacy
            'youtubeCookies' => false,
            // developer settings
            'useSingleQuotes' => false,
            'height' => 0,
            'heightPercentage' => 0,
            'id' => "",
            'class' => "",
            'useParagraph' => false,
            'maxlength' => 0,
            'callback' => null,
            'useTabForNext' => false
        ];
        if ($validator->fails()) {
            throw new \Exception('Editor validation', $validator->errors());
        }
        $params = $validator->validated();
        if (count($params) > 0) {
            foreach ($params as $key => $vals) {
                if (!is_array($vals)) {
                    if ($vals == $defaults[$key]) {
                        unset($params[$key]);
                    }
                }
            }
            if ($addTranslations != null && count($addTranslations) > 0) {
                $translations = $this->mergeValues(config('formsbootstrap.editorTranslations'), $addTranslations);
            } else {
                $translations = config('formsbootstrap.editorTranslations');
            }
            foreach ($translations as $key => $trad) {
                $translations[$key] = $this->translateOrPrint($trad);
            }
            $params['translations'] = $translations;
            return json_encode($params, JSON_PRETTY_PRINT);
        }
        return '';
    }
}
