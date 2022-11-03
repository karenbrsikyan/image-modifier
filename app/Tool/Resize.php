<?php

declare(strict_types = 1);

namespace ImageModifier\Tool;

/**
 * Class Resize
 *
 * @package ImageModifier\Tool
 */
class Resize extends AbstractTool
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $width  = $this->params['width'];
        $height = $this->params['height'];

        $image = $this->image;
        $image->resize($width, $height);

        return $image;
    }
}
