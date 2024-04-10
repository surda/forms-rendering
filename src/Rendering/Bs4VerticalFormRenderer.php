<?php declare(strict_types=1);

namespace Surda\Forms\Rendering;

use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Rendering\DefaultFormRenderer;

class Bs4VerticalFormRenderer extends DefaultFormRenderer
{
    use TFormRenderOverrider;
    
    /** @var bool */
    private $isInitialized = FALSE;

    public function __construct()
    {
        $this->wrappers['error']['container'] = NULL;
        $this->wrappers['error']['item'] = 'div class="alert alert-danger" role=alert';
        $this->wrappers['controls']['container'] = NULL;
        $this->wrappers['pair']['container'] = 'div class="form-group"';
        $this->wrappers['control']['container'] = NULL;
        $this->wrappers['control']['description'] = 'small class="form-text text-muted"';
        $this->wrappers['control']['errorcontainer'] = 'div class=invalid-feedback';
        $this->wrappers['control']['.error'] = 'is-invalid';
        $this->wrappers['control']['.file'] = 'form-file';
        $this->wrappers['label']['container'] = NULL;
        $this->wrappers['btn']['primary'] = 'btn btn-primary';
        $this->wrappers['btn']['secondary'] = 'btn btn-secondary';
    }

    private function controlsInit(): void
    {
        if ($this->isInitialized === TRUE) {
            return;
        }

        $this->isInitialized = TRUE;

        $usedPrimary = FALSE;

        foreach ($this->form->getControls() as $control) {
            $type = $control->getOption('type');
            if ($type === 'button') {
                $control->getControlPrototype()->addClass($usedPrimary === FALSE ? $this->getValue('btn primary') : $this->getValue('btn secondary'));
                $usedPrimary = TRUE;
            } elseif (in_array($type, ['text', 'textarea', 'select'], TRUE)) {
                $control->getControlPrototype()->addClass('form-control');
            } elseif ($type === 'file') {
                $control->getControlPrototype()->addClass('form-control-file');
            } elseif (in_array($type, ['checkbox', 'radio'], TRUE)) {
                if ($control instanceof Checkbox) {
                    $control->getLabelPrototype()->addAttributes(['class' => 'form-check-label']);
                } else {
                    $control->getItemLabelPrototype()->addAttributes(['class' => 'form-check-label']);
                }
                $control->getControlPrototype()->addAttributes(['class' => 'form-check-input']);
                $control->getSeparatorPrototype()->setName('div')->addAttributes(['class' => 'form-check']);
            }
        }
    }
}