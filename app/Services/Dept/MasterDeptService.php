<?php

namespace App\Services\Dept;

use App\Models\V1\Company;
use Illuminate\Support\Facades\Http;

/**
 * Class MasterDeptService.
 */
class MasterDeptService
{
    public function handle()
    {
        $text = 'https://api-pharma.kalbe.co.id/v1/ListDept';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        // // Memfilter data berdasarkan EmpCompany "01" dan OrgGroupName yang mengandung "KF BO"
        // $filteredResponse = array_filter($response, function ($item) {
        //     return isset($item['EmpCompany'], $item['OrgGroupName']) &&
        //         $item['EmpCompany'] === '01' &&
        //         strpos($item['OrgGroupName'], 'KF BO') !== false;
        // });

        $companyList = Company::pluck('compCode')->toArray(); // ubah jadi array biasa

        $filteredResponse = array_filter($response, function ($item) use ($companyList) {
            return isset($item['EmpCompany'], $item['OrgGroupName']) &&
                in_array($item['EmpCompany'], $companyList);
        });

        // Ambil hanya OrgGroupName dan EmpOrg
        // $mappedResponse = array_map(function ($item) {
        //     return [
        //         'OrgGroupName' => $item['OrgGroupName'],
        //         'OrgGroup' => $item['OrgGroup'],
        //     ];
        // }, $filteredResponse);

        // Hapus duplikat
        $uniqueResponse = array_unique($filteredResponse, SORT_REGULAR);
        return $uniqueResponse;
    }
}
