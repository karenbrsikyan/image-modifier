<?php

declare(strict_types = 1);

namespace ImageModifier\Tests\Unit\Tool;

use PHPUnit\Framework\TestCase;
use ImageModifier\Tool\Crop;
use Gumlet\ImageResize;

class CropTest extends TestCase
{
    private const SAMPLE_IMAGE = __DIR__ . '/../../screen.png';

    public function testExecute()
    {
        $tool = new Crop();

        $tool->setImage(new ImageResize(self::SAMPLE_IMAGE));
        $tool->setParams([
            'width' => 100,
            'height' => 50,
        ]);

        $image = $tool->execute();

        $this->assertInstanceOf(ImageResize::class, $image);
        $this->assertEquals(100, $image->getDestWidth());
        $this->assertEquals(50, $image->getDestHeight());
        $this->assertEquals(IMAGETYPE_PNG, $image->source_type);
    }
}