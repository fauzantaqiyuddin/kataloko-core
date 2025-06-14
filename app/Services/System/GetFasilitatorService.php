<?php

namespace App\Services\System;

use App\Models\User;
use Illuminate\Support\Facades\Http;

/**
 * Class GetFasilitatorService.
 */
class GetFasilitatorService
{
    public function handle($data)
    {
        if (User::where('employeId', $data->supervisor)->first()) {
            # code...
            $mentor = User::where('employeId', $data->supervisor)->first();
            return [
                'fullname' => $mentor->fullname,
                'nik' => $mentor->employeId,
                'dept' => $mentor->groupName
            ];
        } else {
            # code...
            return $this->hrisGetEmployee($data->supervisor)[0] ?? 'NA';
        }
    }

    public function hrisGetEmployee($nik)
    {
        $text = 'https://api-pharma.kalbe.co.id/v1/ListUsers/Nik?SearchbyNIK=' . $nik;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        $data = [];
        foreach ($response as $item) {
            # code...
            $data[] = [
                'nik' => $item['EmpID'],
                'fullname' => $item['EmployeeName'],
                'dept' => $item['OrgGroupName'],
                'email' => $item['EmpEmail'],
            ];
        }

        return $data;
    }

    public function getByEmail($email)
    {
        $text = 'https://api-pharma.kalbe.co.id/v1/ListUsers/Email?SearchbyEmail=' . $email;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        $data = [];
        foreach ($response as $item) {
            # code...
            $data[] = [
                'nik' => $item['EmpID'],
                'fullname' => $item['EmployeeName'],
                'dept' => $item['OrgGroupName'],
                'email' => $item['EmpEmail'],
            ];
        }

        return $data[0];
    }
}
