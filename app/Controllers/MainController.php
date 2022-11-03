<?php

declare(strict_types = 1);

namespace ImageModifier\Controllers;

use ImageModifier\ModifierService;
use ImageModifier\Utility\Normalizer;
use Gumlet\ImageResize;

class MainController
{
    public function samplePageAction()
    {
        try {
            $imageFilePath = STORAGE_PATH . '/images/original/screen.png';

            $originalImageEncoded = (string) (new ImageResize($imageFilePath));

            $croppedImage = (new ModifierService(
                new ImageResize($imageFilePath),
                'crop',
                [
                    'width' => 100,
                    'height' => 300,
                ]
            ))->modify();
            $cropeedImageEncoded = (string) $croppedImage;

            $resizedImage = (new ModifierService(
                new ImageResize($imageFilePath),
                'resize',
                [
                    'width' => 200,
                    'height' => 100,
                ]
            ))->modify();
            $resizedImageEncoded = (string) $resizedImage;
        } catch (\Throwable $e) {
            include_once VIEW_PATH . '/error/404.php';
        }

        include_once VIEW_PATH . '/sample-page.php';
    }

    /**
     * @param string $image    - filename of the image to be modified
     * @param string $modifier - modifier tool name
     * @param int    $width    - width of the destination image
     * @param int    $height   - height of the destination image
     */
    public function modifierAction(string $image, string $modifier, int $width, int $height)
    {
        try {
            $imageObj = new ImageResize(STORAGE_PATH . '/images/original/' . $image);

            $service = new ModifierService(
                $imageObj,
                $modifier,
                [
                    'width' => $width,
                    'height' => $height,
                ]
            );

            $modifiedImage = $service->modify();

            $destinationFile = Normalizer::generateFilename() . '.' . pathinfo($image, PATHINFO_EXTENSION);
            $modifiedImage->save(STORAGE_PATH . '/images/modified/' . $destinationFile, $modifiedImage->source_type);

            header("Location: /$destinationFile");
            exit;
        } catch (\Throwable $e) {
            include_once VIEW_PATH . '/error/404.php';
        }
    }

    /**
     * Shows the destination image
     *
     * @param string $image
     */
    public function showAction(string $image)
    {
        try {
            $imageObj = new ImageResize(STORAGE_PATH . '/images/modified/' . $image);
            $imageObj->output();
        } catch (\Throwable $e) {
            include_once VIEW_PATH . '/error/404.php';
        }
    }

    /**
     * 404 Error page action
     */
    public function errorAction()
    {
        include_once VIEW_PATH . '/error/404.php';
    }
}