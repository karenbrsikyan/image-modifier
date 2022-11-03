<?php

declare(strict_types = 1);

namespace ImageModifier\Tool;

use Gumlet\ImageResize;

/**
 * Class Crop
 *
 * @package ImageModifier\Tool
 */
class Crop extends AbstractTool
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $width  = $this->params['width'];
        $height = $this->params['height'];

        $image = $this->image;
        $image->crop($width, $height, true, ImageResize::CROPTOPCENTER);

        return $image;
    }
}
