<?php
namespace Seblhaire\Formsbootstrap;

interface FormsBootstrapServiceContract {
    public function bsOpen($data);
    public function bsHidden($data);
    public function bsText($data);
    public function bsNumber($data);
    public function bsRange($data);
    public function bsTextarea($data);
    public function bsEmail($data = []);
    public function bsPassword($data  = []);
    public function bsPasswordWithConfirm($data  = []);
    public function bsSelect($data);
    public function bsCheckbox($data);
    public function bsRadio($data);
    public function bsSubmit($data);
    public function bsButton($data);
    public function bsColorpicker($data);
    public function bsEditor($data);
    public function bsClose();
    public function validateEditorParams($params = null, $addTranslations = null);
}
