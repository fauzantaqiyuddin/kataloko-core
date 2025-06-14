<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Http;

/**
 * Class GetCompanySiteService.
 */
class GetCompanySiteService
{
    public function handle($request)
    {
        $text = 'https://api-pharma.kalbe.co.id/v1/ListCompany';
        $search = $request->input('search');

        $data = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $data = $data->json();

        // Filter manual di PHP jika API tidak support query param
        $filtered = collect($data)->filter(function ($item) use ($search) {
            return str_contains(strtolower($item['EmpCompany']), strtolower($search)) ||
                str_contains(strtolower($item['CompName']), strtolower($search));
        });

        // Ambil maksimal 10 (opsional, untuk efisiensi)
        $limited = $filtered->values()->take(10);

        return response()->json($limited);
    }
}
