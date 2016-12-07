<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 05/08/16
 * Time: 09:43
 */

namespace Modules\Core\Helpers;


use Exception;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Mindy\Helper\Alias;
use Mindy\Orm\Traits\ImageProcess;

class ImageHelper
{
    use ImageProcess;

    public $defaultOptions = [
        'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
        'resolution-x' => 72,
        'resolution-y' => 72,
        'jpeg_quality' => 100,
        'quality' => 100,
        'png_compression_level' => 0
    ];

    /**
     * @var array|null
     *
     * File MUST be described relative to "www" directory!
     *
     * example
     * [
     *  'file' => 'static/images/watermark.png',
     *  'position' => [200,100]
     * ]
     *
     * OR
     *
     * [
     *  'file' => 'static/images/watermark.png',
     *  'position' => 'top'
     * ]
     *
     * position can be array [x,y] coordinates or
     * string with one of available position
     * top, top-left, top-right, bottom, bottom-left, bottom-right, left, right, center, repeat
     */
    public $watermark = null;

    protected function getImagePath($url)
    {
        $basePath = Alias::get('www.media');
        return $basePath . '/' . ltrim($url, '/');
    }

    public function process($imageUrl, $options = [], $watermark = null)
    {
        $path = $this->getImagePath($imageUrl);

        $ext = isset($size['format']) ? $size['format'] : pathinfo($path, PATHINFO_EXTENSION);
        if (isset($options['width']) || isset($options['height'])) {
            $width = $options['width'];
            $height = $options['height'];
            $newImagePath = $this->getNewImagePath($path, $width, $height, $ext);
        } else {
            throw new Exception('Missing width and height');
        }

        if (MINDY_DEBUG && !is_file($path) || isset($options['force']) && $options['force']) {
            $source = $this->makeImage($path, $width, $height, $ext, array_merge($this->defaultOptions, $options));
            if ($watermark) {
                $source = $this->applyWatermark($source, $watermark);
            }
            file_put_contents($newImagePath, $source->get($ext, $options));
        }
        return str_replace(Alias::get('www'), '', $newImagePath);
    }

    protected function getNewImagePath($path, $width, $height, $ext)
    {
        $basenameWithPath = mb_substr($path, 0, strpos($path, '.' . $ext), 'UTF-8');
        return strtr('{path}_{width}x{height}.{ext}', [
            '{path}' => $basenameWithPath,
            '{width}' => $width,
            '{height}' => $height,
            '{ext}' => $ext
        ]);
    }

    protected function makeImage($path, $width = null, $height = null, $ext = null, $options = [])
    {
        static $defaultResize = 'adaptiveResizeFromTop';
        static $resizeMethods = [
            'resize',
            'adaptiveResize',
            'adaptiveResizeFromTop'
        ];

        $source = $this->getImagine()->load(file_get_contents($path));
        if (!$width || !$height) {
            list($width, $height) = $this->imageScale($source, $width, $height);
        }

        $method = isset($size['method']) ? $size['method'] : $defaultResize;
        if (!in_array($method, $resizeMethods)) {
            throw new Exception('Unknown resize method: ' . $method);
        }

        return $this->resize($source->copy(), $width, $height, $method);
    }
}