<?php

declare(strict_types = 1);

namespace ImageModifier;

use ImageModifier\Tool\AbstractTool;
use Gumlet\ImageResize;

/**
 * Service class for the image modifiers
 *
 * @package ImageModifier
 */
class ModifierService
{
    /**
     * @var ImageResize $image 
     */
    protected $image;

    /**
     * @var string $modifier 
     */
    protected $modifier;

    /**
     * ModifierService constructor
     *
     * @param ImageResize $image
     * @param string      $modifier
     * @param array       $params
     */
    public function __construct(
        ImageResize $image,
        string $modifier,
        array $params
    ) {
        $this->image = $image;
        $this->modifier = $modifier;
        $this->params = $params;
    }

    /**
     * The main modify method responsible for the tools execution
     *
     * @return ImageResize
     */
    public function modify(): ImageResize
    {
        /**
         * @var AbstractTool $tool
        */
        $tool = $this->factory();

        $tool->setImage($this->image);
        $tool->setParams($this->params);

        return $tool->execute();
    }

    /**
     * The factory method to retrieve the corresponding tool class from the modifier
     *
     * @return AbstractTool
     *
     * @throws \BadMethodCallException
     */
    public function factory() : AbstractTool
    {
        $className = 'ImageModifier\Tool\\' . ucfirst($this->modifier);

        if (class_exists($className)) {
            return new $className;
        }

        throw new \BadMethodCallException(sprintf('Cannot create new %s class.', $this->modifier));
    }
}
