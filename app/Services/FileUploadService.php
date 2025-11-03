<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class FileUploadService
{
  /**
   * File type configurations
   */
  private const FILE_CONFIGS = [
    'image' => [
      'mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
      'max_size' => 5120, // 5MB in KB
      'storage_path' => 'images',
    ],
    'document' => [
      'mimes' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
      'max_size' => 10240, // 10MB in KB
      'storage_path' => 'documents',
    ],
    'cover_image' => [
      'mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
      'max_size' => 3072, // 3MB in KB
      'storage_path' => 'covers',
    ],
    'featured_image' => [
      'mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
      'max_size' => 3072, // 3MB in KB
      'storage_path' => 'featured',
    ],
    'client_image' => [
      'mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
      'max_size' => 2048, // 2MB in KB
      'storage_path' => 'clients',
    ],
    'gallery_image' => [
      'mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
      'max_size' => 8192, // 8MB in KB
      'storage_path' => 'gallery',
    ],
  ];

  /**
   * Upload a single file with validation and optimization
   */
  public function upload(UploadedFile $file, string $type, string $subfolder = null): string
  {
    $config = $this->getFileConfig($type);

    // Validate file
    $this->validateFile($file, $config);

    // Generate storage path
    $storagePath = $this->generateStoragePath($config['storage_path'], $subfolder);

    // Generate unique filename
    $filename = $this->generateUniqueFilename($file);

    // Store file
    $fullPath = $file->storeAs($storagePath, $filename, 'public');

    // Optimize if it's an image (non-critical - don't fail upload if optimization fails)
    if ($this->isImageType($type)) {
      try {
        app(ImageOptimizationService::class)->optimize(storage_path('app/public/' . $fullPath));
      } catch (\Exception $e) {
        // Log error but don't fail the upload
        Log::warning('Image optimization failed, but upload succeeded: ' . $e->getMessage());
      }
    }

    return $fullPath;
  }

  /**
   * Upload multiple files
   */
  public function uploadMultiple(array $files, string $type, string $subfolder = null): array
  {
    $uploadedFiles = [];

    foreach ($files as $file) {
      if ($file instanceof UploadedFile) {
        $uploadedFiles[] = $this->upload($file, $type, $subfolder);
      }
    }

    return $uploadedFiles;
  }

  /**
   * Replace an existing file
   */
  public function replace(UploadedFile $newFile, string $type, string $oldFilePath = null, string $subfolder = null): string
  {
    // Delete old file if exists
    if ($oldFilePath) {
      $this->delete($oldFilePath);
    }

    // Upload new file
    return $this->upload($newFile, $type, $subfolder);
  }

  /**
   * Delete a file
   */
  public function delete(string $filePath): bool
  {
    if (Storage::disk('public')->exists($filePath)) {
      return Storage::disk('public')->delete($filePath);
    }

    return false;
  }

  /**
   * Delete multiple files
   */
  public function deleteMultiple(array $filePaths): int
  {
    $deletedCount = 0;

    foreach ($filePaths as $filePath) {
      if ($this->delete($filePath)) {
        $deletedCount++;
      }
    }

    return $deletedCount;
  }

  /**
   * Get file configuration
   */
  private function getFileConfig(string $type): array
  {
    if (!isset(self::FILE_CONFIGS[$type])) {
      throw new InvalidArgumentException("Unsupported file type: {$type}");
    }

    return self::FILE_CONFIGS[$type];
  }

  /**
   * Validate uploaded file
   */
  private function validateFile(UploadedFile $file, array $config): void
  {
    // Check if file is valid
    if (!$file->isValid()) {
      throw new InvalidArgumentException('Invalid file upload');
    }

    // Check file size
    $sizeInKB = $file->getSize() / 1024;
    if ($sizeInKB > $config['max_size']) {
      throw new InvalidArgumentException(
        "File size ({$sizeInKB}KB) exceeds maximum allowed size ({$config['max_size']}KB)"
      );
    }

    // Check file type
    $extension = strtolower($file->getClientOriginalExtension());
    if (!in_array($extension, $config['mimes'])) {
      throw new InvalidArgumentException(
        "File type '{$extension}' is not allowed. Allowed types: " . implode(', ', $config['mimes'])
      );
    }

    // Additional security check - verify MIME type
    $mimeType = $file->getMimeType();
    if (!$this->isValidMimeType($mimeType, $extension)) {
      throw new InvalidArgumentException('File type does not match file content');
    }
  }

  /**
   * Generate storage path
   */
  private function generateStoragePath(string $basePath, string $subfolder = null): string
  {
    $path = $basePath;

    if ($subfolder) {
      $path .= '/' . Str::slug($subfolder);
    }

    // Add date-based subfolder for better organization
    $path .= '/' . date('Y/m');

    return $path;
  }

  /**
   * Generate unique filename
   */
  private function generateUniqueFilename(UploadedFile $file): string
  {
    $extension = strtolower($file->getClientOriginalExtension());
    $basename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

    // Limit basename length
    $basename = Str::limit($basename, 50, '');

    // Add timestamp and random string for uniqueness
    return $basename . '_' . time() . '_' . Str::random(8) . '.' . $extension;
  }

  /**
   * Check if file type is an image
   */
  private function isImageType(string $type): bool
  {
    return in_array($type, ['image', 'cover_image', 'featured_image', 'client_image', 'gallery_image']);
  }

  /**
   * Validate MIME type against extension
   */
  private function isValidMimeType(string $mimeType, string $extension): bool
  {
    $validMimes = [
      'jpg' => ['image/jpeg'],
      'jpeg' => ['image/jpeg'],
      'png' => ['image/png'],
      'gif' => ['image/gif'],
      'webp' => ['image/webp'],
      'pdf' => ['application/pdf'],
      'doc' => ['application/msword'],
      'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
      'xls' => ['application/vnd.ms-excel'],
      'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
      'ppt' => ['application/vnd.ms-powerpoint'],
      'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
    ];

    return isset($validMimes[$extension]) && in_array($mimeType, $validMimes[$extension]);
  }

  /**
   * Get file info
   */
  public function getFileInfo(string $filePath): array
  {
    if (!Storage::disk('public')->exists($filePath)) {
      return [];
    }

    $fullPath = storage_path('app/public/' . $filePath);

    return [
      'path' => $filePath,
      'url' => Storage::disk('public')->url($filePath),
      'size' => Storage::disk('public')->size($filePath),
      'size_human' => $this->formatBytes(Storage::disk('public')->size($filePath)),
      'mime_type' => mime_content_type($fullPath),
      'last_modified' => Storage::disk('public')->lastModified($filePath),
    ];
  }

  /**
   * Format bytes to human readable format
   */
  private function formatBytes(int $bytes, int $precision = 2): string
  {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
      $bytes /= 1024;
    }

    return round($bytes, $precision) . ' ' . $units[$i];
  }

  /**
   * Get supported file types
   */
  public static function getSupportedTypes(): array
  {
    return array_keys(self::FILE_CONFIGS);
  }

  /**
   * Get configuration for a file type
   */
  public static function getTypeConfig(string $type): array
  {
    return self::FILE_CONFIGS[$type] ?? [];
  }
}
