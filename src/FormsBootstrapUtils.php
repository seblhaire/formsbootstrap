<?php
namespace Seblhaire\Formsbootstrap;

use Illuminate\Support\Facades\Validator;
/**
 * Helpers for package formsbootstrap
 */
class FormsBootstrapUtils
{
  /**
   * translate key between ## or returns unchanged key
   * @param  string $key key to translate
   * @return string      translated key
   */
  public static function translateOrPrint($key)
  {
    if (preg_match('/^\#(.+)\#$/', $key, $matches)){
      return __($matches[1]);
    }
    return $key;
  }

/**
 * recursively updates parameters with new values.
 * @param  array $defaults  orignal mutlidimensional values
 * @param  array $newValues values to replace
 * @return array            merge results
 */
  public static function mergeValues($defaults, $newValues){
    if (count($newValues) > 0){
      foreach ($newValues as $key => $value){
        if (is_array($value)){
          if (!isset($defaults[$key])) $defaults[$key] = [];
          $defaults[$key] = self::mergeValues($defaults[$key], $value);
        }else{
          $defaults[$key] = $value;
        }
      }
    }
    return $defaults;
  }

  public static function validateEditorParams($params = null, $addTranslations = false){
    if (!is_array($params) && !is_null($params)) {
      throw new \Exception('no array');
    }
    if (is_null($params)){
      $params = config('formsbootstrap.defaults.editor.config');
    }
    $stringarray = function ($attribute, $a, $fail) {
      foreach($a as $v)
       if (!is_string($v)) {
           $fail('array must contain strings');
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
      'colors' =>  [
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
    if (count($params) > 0){
      foreach($params as $key => $vals){
        if (!is_array($vals)){
          if ($vals == $defaults[$key]){
            unset($params[$key]);
          }
        }
      }
      if (count($params) > 0){
        if ($addTranslations){
          $translations = [];
          foreach (config('formsbootstrap.editorTranslations') as $key => $trad){
            $translations[$key] = self::translateOrPrint($trad);
          }
          $params['translations'] = $translations;
        }
        return json_encode($params);
      }
    }
    return '';
  }
}
