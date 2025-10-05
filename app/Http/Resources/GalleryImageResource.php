<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'gallery_id' => $this->gallery_id,
            'image_path' => $this->image_path,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'alt_text' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('alt_text', $lang) ?? $this->alt_text) : $this->alt_text,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'file_size' => $this->file_size, // Uses model accessor
            'file_size_human' => $this->when($this->file_size, function () {
                return $this->formatBytes($this->file_size);
            }),

            // Related gallery (only when requested)
            'gallery' => $this->when(
                $request->get('include_gallery'),
                new GalleryResource($this->whenLoaded('gallery'))
            ),
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($size, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, $precision) . ' ' . $units[$unit];
    }
}
