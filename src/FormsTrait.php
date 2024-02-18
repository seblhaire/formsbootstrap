<?php

namespace Seblhaire\Formsbootstrap;

use Illuminate\Support\Facades\Validator;
use function Stringy\create as s;

/**
 * Helpers for package formsbootstrap
 */
trait FormsTrait{
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
            if (in_array($key, $default)) {
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
        if (count($code) > 0) {
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

    public function validateEditorParams($params = null, $addTranslations = null) {
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
