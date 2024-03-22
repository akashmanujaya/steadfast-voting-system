<?php

namespace App\Transformers;

/**
 * Class ItemTransformer
 *
 * Provides functionality to transform collections of Item models
 * for API responses, ensuring a consistent output format.
 */
class ItemTransformer
{
    /**
     * Transforms a collection of items into a standardized array format.
     * 
     * Iterates over each item, extracting and formatting specific fields for the API response.
     *
     * @param \Illuminate\Database\Eloquent\Collection $items The collection of Item models to transform.
     * @return \Illuminate\Support\Collection A collection of transformed items, each as an associative array.
     */
    public static function transform($items)
    {
        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'icon' => $item->icon,
            ];
        });
    }
}
