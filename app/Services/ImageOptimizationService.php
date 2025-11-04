<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ImageOptimizationService
{
  /**
   * Image optimization settings
   */
  private static array $optimizationSettings = [
    'jpeg_quality' => 85,
    'png_compression' => 6,
    'webp_quality' => 80,
    'max_width' => 1920,
    'max_height' => 1080,
    'thumbnail_width' => 300,
    'thumbnail_height' => 300,
  ];

  /**
   * Optimize an image file
   */
  public function optimize(string $filePath): bool
  {
    if (!\file_exists($filePath)) {
      Log::warning("Image optimization: File not found - {$filePath}");
      return false;
    }

    if (!$this->isImage($filePath)) {
      Log::warning("Image optimization: Not an image file - {$filePath}");
      return false;
    }

    try {
      $imageInfo = \getimagesize($filePath);
      if (!$imageInfo) {
        Log::warning("Image optimization: Cannot get image info - {$filePath}");
        return false;
      }

      $mimeType = $imageInfo['mime'];
      $width = $imageInfo[0];
      $height = $imageInfo[1];

      // Create image resource based on type
      $image = $this->createImageFromFile($filePath, $mimeType);
      if (!$image) {
        return false;
      }

      // Resize if necessary
      if (
        $width > self::$optimizationSettings['max_width'] ||
        $height > self::$optimizationSettings['max_height']
      ) {

        $image = $this->resizeImage($image, $width, $height);
      }

      // Save optimized image
      $success = $this->saveOptimizedImage($image, $filePath, $mimeType);

      // Clean up memory
      \imagedestroy($image);

      if ($success) {
        Log::info("Image optimized successfully: {$filePath}");
      }

      return $success;
    } catch (\Exception $e) {
      Log::error("Image optimization failed: {$filePath} - " . $e->getMessage());
      return false;
    }
  }

  /**
   * Create thumbnail from image
   */
  public function createThumbnail(string $sourcePath, string $thumbnailPath = null): string|false
  {
    if (!\file_exists($sourcePath) || !$this->isImage($sourcePath)) {
      return false;
    }

    try {
      $imageInfo = \getimagesize($sourcePath);
      if (!$imageInfo) {
        return false;
      }

      $mimeType = $imageInfo['mime'];
      $sourceImage = $this->createImageFromFile($sourcePath, $mimeType);
      if (!$sourceImage) {
        return false;
      }

      // Create thumbnail
      $thumbnail = $this->createThumbnailImage($sourceImage, $imageInfo[0], $imageInfo[1]);

      // Generate thumbnail path if not provided
      if (!$thumbnailPath) {
        $pathInfo = \pathinfo($sourcePath);
        $thumbnailPath = $pathInfo['dirname'] . '/' .
          $pathInfo['filename'] . '_thumb.' .
          $pathInfo['extension'];
      }

      // Save thumbnail
      $success = $this->saveOptimizedImage($thumbnail, $thumbnailPath, $mimeType);

      // Clean up memory
      \imagedestroy($sourceImage);
      \imagedestroy($thumbnail);

      return $success ? $thumbnailPath : false;
    } catch (\Exception $e) {
      Log::error("Thumbnail creation failed: {$sourcePath} - " . $e->getMessage());
      return false;
    }
  }

  /**
   * Convert image to WebP format
   */
  public function convertToWebP(string $sourcePath, string $webpPath = null): string|false
  {
    if (!\file_exists($sourcePath) || !$this->isImage($sourcePath)) {
      return false;
    }

    // Check if WebP is supported
    if (!\function_exists('imagewebp')) {
      Log::warning("WebP conversion: WebP not supported on this system");
      return false;
    }

    try {
      $imageInfo = \getimagesize($sourcePath);
      if (!$imageInfo) {
        return false;
      }

      $image = $this->createImageFromFile($sourcePath, $imageInfo['mime']);
      if (!$image) {
        return false;
      }

      // Generate WebP path if not provided
      if (!$webpPath) {
        $pathInfo = \pathinfo($sourcePath);
        $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
      }

      // Convert to WebP
      $success = \imagewebp($image, $webpPath, self::$optimizationSettings['webp_quality']);

      // Clean up memory
      \imagedestroy($image);

      if ($success) {
        Log::info("Image converted to WebP: {$webpPath}");
      }

      return $success ? $webpPath : false;
    } catch (\Exception $e) {
      Log::error("WebP conversion failed: {$sourcePath} - " . $e->getMessage());
      return false;
    }
  }

  /**
   * Get optimized image dimensions
   */
  public function getOptimizedDimensions(int $width, int $height): array
  {
    $maxWidth = self::$optimizationSettings['max_width'];
    $maxHeight = self::$optimizationSettings['max_height'];

    if ($width <= $maxWidth && $height <= $maxHeight) {
      return ['width' => $width, 'height' => $height];
    }

    $ratio = \min($maxWidth / $width, $maxHeight / $height);

    return [
      'width' => (int) \round($width * $ratio),
      'height' => (int) \round($height * $ratio)
    ];
  }

  /**
   * Check if file is an image
   */
  private function isImage(string $filePath): bool
  {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mimeType = \mime_content_type($filePath);

    return \in_array($mimeType, $allowedTypes);
  }

  /**
   * Create image resource from file
   */
  private function createImageFromFile(string $filePath, string $mimeType)
  {
    switch ($mimeType) {
      case 'image/jpeg':
        return \imagecreatefromjpeg($filePath);
      case 'image/png':
        return \imagecreatefrompng($filePath);
      case 'image/gif':
        return \imagecreatefromgif($filePath);
      case 'image/webp':
        return \function_exists('imagecreatefromwebp') ?
          \imagecreatefromwebp($filePath) : false;
      default:
        return false;
    }
  }

  /**
   * Resize image maintaining aspect ratio
   */
  private function resizeImage($sourceImage, int $sourceWidth, int $sourceHeight)
  {
    $newDimensions = $this->getOptimizedDimensions($sourceWidth, $sourceHeight);
    $newWidth = $newDimensions['width'];
    $newHeight = $newDimensions['height'];

    // Create new image
    $resizedImage = \imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG and GIF
    \imagealphablending($resizedImage, false);
    \imagesavealpha($resizedImage, true);

    // Resize
    \imagecopyresampled(
      $resizedImage,
      $sourceImage,
      0,
      0,
      0,
      0,
      $newWidth,
      $newHeight,
      $sourceWidth,
      $sourceHeight
    );

    return $resizedImage;
  }

  /**
   * Create thumbnail image
   */
  private function createThumbnailImage($sourceImage, int $sourceWidth, int $sourceHeight)
  {
    $thumbWidth = self::$optimizationSettings['thumbnail_width'];
    $thumbHeight = self::$optimizationSettings['thumbnail_height'];

    // Calculate dimensions to maintain aspect ratio
    $ratio = \min($thumbWidth / $sourceWidth, $thumbHeight / $sourceHeight);
    $newWidth = (int) \round($sourceWidth * $ratio);
    $newHeight = (int) \round($sourceHeight * $ratio);

    // Create thumbnail
    $thumbnail = \imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency
    \imagealphablending($thumbnail, false);
    \imagesavealpha($thumbnail, true);

    // Resize
    \imagecopyresampled(
      $thumbnail,
      $sourceImage,
      0,
      0,
      0,
      0,
      $newWidth,
      $newHeight,
      $sourceWidth,
      $sourceHeight
    );

    return $thumbnail;
  }

  /**
   * Save optimized image
   */
  private function saveOptimizedImage($image, string $filePath, string $mimeType): bool
  {
    switch ($mimeType) {
      case 'image/jpeg':
        return \imagejpeg($image, $filePath, self::$optimizationSettings['jpeg_quality']);
      case 'image/png':
        return \imagepng($image, $filePath, self::$optimizationSettings['png_compression']);
      case 'image/gif':
        return \imagegif($image, $filePath);
      case 'image/webp':
        return \function_exists('imagewebp') ?
          \imagewebp($image, $filePath, self::$optimizationSettings['webp_quality']) : false;
      default:
        return false;
    }
  }

  /**
   * Get image information
   */
  public function getImageInfo(string $filePath): array
  {
    if (!\file_exists($filePath) || !$this->isImage($filePath)) {
      return [];
    }

    $imageInfo = \getimagesize($filePath);
    if (!$imageInfo) {
      return [];
    }

    $fileSize = \filesize($filePath);

    return [
      'width' => $imageInfo[0],
      'height' => $imageInfo[1],
      'type' => $imageInfo[2],
      'mime_type' => $imageInfo['mime'],
      'file_size' => $fileSize,
      'file_size_human' => $this->formatBytes($fileSize),
      'channels' => $imageInfo['channels'] ?? null,
      'bits' => $imageInfo['bits'] ?? null,
    ];
  }

  /**
   * Format bytes to human readable format
   */
  private function formatBytes(int $bytes, int $precision = 2): string
  {
    $units = ['B', 'KB', 'MB', 'GB'];

    for ($i = 0; $bytes > 1024 && $i < \count($units) - 1; $i++) {
      $bytes /= 1024;
    }

    return \round($bytes, $precision) . ' ' . $units[$i];
  }

  /**
   * Update optimization settings
   */
  public function updateSettings(array $settings): void
  {
    foreach ($settings as $key => $value) {
      if (\array_key_exists($key, self::$optimizationSettings)) {
        self::$optimizationSettings[$key] = $value;
      }
    }
  }

  /**
   * Get current optimization settings
   */
  public function getSettings(): array
  {
    return self::$optimizationSettings;
  }
}
