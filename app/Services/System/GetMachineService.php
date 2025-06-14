<?php

namespace App\Services\System;

use App\Models\System\Mesin;

/**
 * Class GetMachineService.
 */
class GetMachineService
{
    public function handle($request)
    {
        $search = $request->search;
        $users = Mesin::where('title', 'like', '%' . $search . '%')
            ->select('id', 'title')
            ->get();

        return response()->json($users);
    }
}
