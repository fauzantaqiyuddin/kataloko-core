<?php

namespace App\Services\V1\Dashboard;

use App\Models\User;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use Illuminate\Support\Facades\DB;

/**
 * Class GetUserTotalCategoryService.
 */
class GetUserTotalCategoryService
{
    public function handle()
    {
        $categories = CategoryUmum::latest()->get();
        $topUsersPerCategory = [];

        foreach ($categories as $category) {
            $topUsers = OnePointLesson::select('user', DB::raw('COUNT(*) as total'))
                ->where('category_umum_id', $category->id)
                ->groupBy('user')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // Ambil semua email user yang unik dari hasil query
            $emails = $topUsers->pluck('user')->unique();

            // Ambil user sekaligus berdasarkan email
            $users = User::whereIn('email', $emails)->get()->keyBy('email');

            // Tambahkan nama dan departemen
            $topUsers->transform(function ($item) use ($users) {
                $user = $users[$item->user] ?? null;
                $item->user_name = $user->fullname ?? 'Unknown';
                $item->dept = $user->groupName ?? 'Unknown';
                return $item;
            });

            $topUsersPerCategory[$category->title] = $topUsers;
        }

        return $topUsersPerCategory;
    }
}
