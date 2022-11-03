<?php

declare(strict_types = 1);

namespace ImageModifier\Tool;

use Gumlet\ImageResize;

/**
 * Class AbstractTool
 *
 * @package ImageModifier\Tool
 */
abstract class AbstractTool
{
    /**
     * @var ImageResize $image 
     */
    protected $image;

    /**
     * @var array $params 
     */
    protected $params;

    public function setImage(ImageResize $image)
    {
        $this->image = $image;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Apply the updates to the original image
     *
     * @return ImageResize The updated image resource
     */
    abstract public function execute();
}
