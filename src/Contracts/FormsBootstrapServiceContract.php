<?php
namespace Seblhaire\Formsbootstrap\Contracts;

interface FormsBootstrapServiceContract {
    public function bsOpen($data) : string;
    public function bsHidden($data) : string;
    public function bsText($data) : string;
    public function bsNumber($data) : string;
    public function bsRange($data) : string;
    public function bsTextarea($data) : string;
    public function bsEmail($data = []) : string;
    public function bsPassword($data  = []) : string;
    public function bsPasswordWithConfirm($data  = []) : string;
    public function bsSelect($data) : string;
    public function bsCheckbox($data) : string;
    public function bsRadio($data) : string;
    public function bsSubmit($data) : string;
    public function bsButton($data) : string;
    public function bsColorpicker($data) : string;
    public function bsEditor($data) : string;
    public function bsClose() : string;
    public function validateEditorParams($params = null, $addTranslations = null): string;
    public function printJs(): string;
    public function printJsById(string $id): string;
    public function translateOrPrint($key) : string;
}
