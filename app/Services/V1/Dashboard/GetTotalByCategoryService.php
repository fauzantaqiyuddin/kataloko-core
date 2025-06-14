<?php

namespace App\Services\V1\Dashboard;

use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use Illuminate\Support\Facades\DB;

/**
 * Class GetTotalByCategoryService.
 */
class GetTotalByCategoryService
{
    public function handle()
    {
        $categories = CategoryUmum::leftJoin('one_point_lessons', 'category_umums.id', '=', 'one_point_lessons.category_umum_id')
            ->select('category_umums.title', DB::raw('COUNT(one_point_lessons.id) as total'))
            ->groupBy('category_umums.title')
            ->get();

        $categoryArray = [];
        foreach ($categories as $category) {
            $categoryArray[$category->title] = $category->total ?? 0; // jika null, set ke 0
        }

        return $categoryArray;
    }
}
