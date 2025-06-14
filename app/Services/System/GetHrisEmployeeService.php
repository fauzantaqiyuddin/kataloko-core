<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Http;

/**
 * Class GetHrisEmployeeService.
 */
class GetHrisEmployeeService
{
    public function handle($request, $groupCode = null)
    {
        // $users = User::where('fullname', 'like', '%' . $request->q . '%')->get();
        $text = 'https://api-pharma.kalbe.co.id/v1/ListUsers/Name?SearchbyName=' . $request->search;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        $data = [];

        foreach ($response as $item) {
            # code...
            $data[] = [
                'id' => $item['EmpID'],
                'title' => $item['EmployeeName'] . ' - ' . $item['OrgName'],
                'nameMail' => $item['EmployeeName'] . ' - ' . $item['OrgGroupName'],
                'email' => $item['EmpEmail'],
                'fullname' => $item['EmployeeName']
            ];
        }

        return response()->json($data, 200);
    }

    public function getByEmail($email)
    {
        // $users = User::where('fullname', 'like', '%' . $request->q . '%')->get();
        $text = 'https://api-pharma.kalbe.co.id/v1/ListUsers/Email?SearchbyEmail=' . $email;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        // $data = [];

        // foreach ($response as $item) {
        //     # code...
        //     $data[] = [
        //         'id' => $item['EmpID'],
        //         'title' => $item['EmployeeName'] . ' - ' . $item['OrgName'],
        //         'nameMail' => $item['EmployeeName'] . ' - ' . $item['OrgGroupName'],
        //         'email' => $item['EmpEmail'],
        //         'fullname' => $item['EmployeeName']
        //     ];
        // }

        return $response;
    }
}
