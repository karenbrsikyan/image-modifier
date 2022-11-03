<?php

declare(strict_types = 1);

namespace ImageModifier\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ImageModifier\ModifierService;
use ImageModifier\Tool\Crop;
use Gumlet\ImageResize;
use Gumlet\ImageResizeException;
use BadMethodCallException;

class ModifierServiceTest extends TestCase
{
    private const SAMPLE_IMAGE = __DIR__ . '/../screen.png';

    public function testModifyExistingImage()
    {
        $croppedImage = (new ModifierService(
            new ImageResize(self::SAMPLE_IMAGE),
            'crop',
            [
                'width' => 100,
                'height' => 300,
            ]
        ))->modify();

        $this->assertInstanceOf(ImageResize::class, $croppedImage);
        $this->assertEquals(100, $croppedImage->getDestWidth());
        $this->assertEquals(300, $croppedImage->getDestHeight());
        $this->assertEquals(IMAGETYPE_PNG, $croppedImage->source_type);
    }

    public function testModifyNonExistingImage()
    {
        $this->expectException(ImageResizeException::class);
        $this->expectExceptionMessage('File does not exist');

        $nonExistingImage = __DIR__ . '/../dummy.png';

        (new ModifierService(
            new ImageResize($nonExistingImage),
            'crop',
            [
                'width' => 100,
                'height' => 300,
            ]
        ))->modify();
    }

    public function testFactoryWithExistingTool()
    {
        $service = new ModifierService(new ImageResize(self::SAMPLE_IMAGE), 'crop', []);

        $toolClass = $service->factory();

        $this->assertInstanceOf(Crop::class, $toolClass);
    }

    public function testFactoryWithNonExistingTool()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Cannot create new dummyTool class.');

        $service = new ModifierService(new ImageResize(self::SAMPLE_IMAGE), 'dummyTool', []);

        $service->factory();
    }
}
