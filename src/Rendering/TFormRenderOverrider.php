<?php declare(strict_types=1);

namespace Surda\Forms\Rendering;

use Nette\Forms\IControl;
use Nette\Utils\Html;

trait TFormRenderOverrider
{
    /**
     * {@inheritDoc}
     */
    public function renderBegin(): string
    {
        $this->controlsInit();

        return parent::renderBegin();
    }


    /**
     * {@inheritDoc}
     */
    public function renderEnd(): string
    {
        $this->controlsInit();

        return parent::renderEnd();
    }


    /**
     * {@inheritDoc}
     */
    public function renderBody(): string
    {
        $this->controlsInit();

        return parent::renderBody();
    }


    /**
     * {@inheritDoc}
     */
    public function renderControls($parent): string
    {
        $this->controlsInit();

        return parent::renderControls($parent);
    }


    /**
     * {@inheritDoc}
     */
    public function renderPair(IControl $control): string
    {
        $this->controlsInit();

        return parent::renderPair($control);
    }


    /**
     * {@inheritDoc}
     */
    public function renderPairMulti(array $controls): string
    {
        $this->controlsInit();

        return parent::renderPairMulti($controls);
    }


    /**
     * {@inheritDoc}
     */
    public function renderLabel(IControl $control): Html
    {
        $this->controlsInit();

        return parent::renderLabel($control);
    }


    /**
     * {@inheritDoc}
     */
    public function renderControl(IControl $control): Html
    {
        $this->controlsInit();

        return parent::renderControl($control);
    }
}