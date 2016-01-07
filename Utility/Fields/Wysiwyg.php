<?php

namespace Modules\Dynamicfield\Utility\Fields;

use Collective\Html\FormFacade;

class Wysiwyg extends FieldBase
{
    public function __construct($fieldInfo, $entityId, $locale)
    {
        parent:: __construct($fieldInfo, $entityId, $locale);
    }

    public function valid()
    {
        $bResult = false;
        if ($this->getOption('required') == 'true') {
            $value = $this->getValue();
            if (empty($value)) {
                $this->isValid = false;
            } else {
                $bResult = true;
            }
        } else {
            $bResult = true;
        }

        return $bResult;
    }
    public function render()
    {
        $attrs = array();
        $id = $this->getHtmlId();
        $name = $this->getHtmlName();
        $value = $this->getValue();
        $label = $this->getLabel();

        $cssClass = 'ckeditor dynamic-editor';
        $errorMessage = '';
        $attrs['id'] = $id;
        if (!$this->isValid) {
            $errorMessage = sprintf("<span class='error'>%s</span>", $this->getErrorMessage());
            $cssClass .= ' error';
        }

        $defaultValue = $this->getOption('default_value');
        if (!strlen($value)) {
            $value = $defaultValue;
        }

        if ($this->getOption('required') == 'true') {
            $cssClass .= ' required';
        }
        $attrs['rows'] = 4;
        if ($this->getOption('rows')) {
            $attrs['rows'] = $this->getOption('rows');
        }
        $attrs['class'] = $cssClass;

        $html = '';
        if (!empty($label)) {
            $html .= FormFacade::label($label);
        }
        $html                .= FormFacade::textarea($name, $value, $attrs).$errorMessage;
        $html = sprintf($this->htmlItemTemplate, $html);

        return $html;
    }

    public function bindEditorScript()
    {
    }

    public function getErrorMessage()
    {
        $error = $this->getOption('error_message');

        return $error;
    }

    public function loadFieldData()
    {
    }
}
