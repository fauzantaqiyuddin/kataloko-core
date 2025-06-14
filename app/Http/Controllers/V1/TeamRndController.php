<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryRnd;
use App\Models\V1\CategoryUmum;
use App\Models\V1\Machine;
use App\Models\V1\OnePointLesson;
use App\Models\V1\Sosialisasi;
use App\Services\System\ApprovalMailService;
use App\Services\System\GetHrisEmployeeService;
use App\Services\System\LogActivityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;

class TeamRndController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->whereNotNull('category_rnd_id')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('publishnya', function ($row) {
                    if ($row->progress == 501) {
                        $publishnya = '<span class="badge text-bg-success">PUBLISH</span>';
                    } else {
                        # code...
                        $publishnya = '<span class="badge text-bg-danger">ON PROGRESS</span>';
                    }

                    return $publishnya;
                })
                ->addColumn('atasan', function ($row) {
                    $getSPV = strstr($row->supervisor, '@', true);
                    return $getSPV;
                })
                ->addColumn('owner', function ($row) {
                    $getOwner = strstr($row->user, '@', true);
                    return $getOwner;
                })

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    if ($row->progress == 501) {
                        # code...
                        $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="avtar avtar-s btn-link-primary inviteMail"><i class="ti ti-mail f-20"></i></a>';
                    } else {
                        # code...
                        $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" class="avtar avtar-s btn-link-primary"><i class="ti ti-cros f-20"></i></a>';
                    }

                    $btn_3 = ' <a href="' . route('v1.teamRnD.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info"><i class="ti ti-eye f-20"></i></a>';
                    $btn = $btn_1 . $btn_3 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('v1.teamRnD.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action', 'publishnya', 'approvalnya', 'atasan', 'owner'])
                ->make(true);
        }
        return view('v1.qualityRnD.index');
    }

    public function show($id, Request $request)
    {
        $data = Onepointlesson::query()
            ->with('mesin', 'lampiran', 'sosialisasi', 'sosialisasiPublish', 'kategoriRnd')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('v1.teamRnD.index')->with('galat', 'OPL Tidak Ditemukan');
        }

        if ($data->status == 'draft') {
            # code...
            return back()->with('galat', 'Silahkan Pilih Menu Edit Saja');
        } else {
            # code...

            if (in_array($data->progress, [102, 202])) {
                # return 
                return back()->with('galat', 'Silahkan Pilih Menu Edit Saja');
            } else {
                # code...
                $category = CategoryUmum::latest()->get();
                if ($request->ajax()) {
                    $data = Sosialisasi::where('opl_id', $data->id)->get();

                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            if ($row->status == 'pending') {
                                # code...
                                $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('v1.onePointLesson.approvalSosialisasi', [
                                    'id' => $row->opl_id,
                                    'id_sosialisasi' => $row->id
                                ]) . '" data-original-title="Delete" data-status="setuju" class="btn btn-success deletePost"><i class="ti ti-check f-20"></i></a>';
                                $btn = $btn_1 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('v1.onePointLesson.approvalSosialisasi', [
                                    'id' => $row->opl_id,
                                    'id_sosialisasi' => $row->id
                                ]) . '" data-original-title="Delete" data-status="tolak" class="btn btn-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                                return $btn;
                            } else {
                                if ($row->status == 'aprove') {
                                    # code...
                                    return 'Complated';
                                } else {
                                    # code...
                                    return 'Not Approval';
                                }
                            }
                        })

                        ->addColumn('sosialisasi', function ($row) {
                            if ($row->sign_trainer) {
                                # code...
                                return Carbon::parse($row->sign_trainer)->format('l, d M Y H:i:s');
                            } else {
                                # code...
                                $loader = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div> Waiting';
                                return $loader;
                            }
                        })

                        ->rawColumns(['action', 'sosialisasi'])
                        ->make(true);
                }

                return view('v1.qualityRnD.show', compact('data', 'category'));
            }
        }
    }

    public function exportExcel()
    {
        try {
            $data = OnePointLesson::query()
                ->with('mesin', 'lampiran', 'sosialisasi', 'sosialisasiPublish', 'kategoriRnd', 'kategori')
                ->whereNotNull('category_rnd_id')
                ->get();

            // Format data untuk Excel
            $formattedData = $data->map(function ($item) {
                $dataEmployeeSuperior = (new GetHrisEmployeeService)->getByEmail($item->supervisor);
                return [
                    'NIK Author' => $item->pemohon ? $item->pemohon->employeId : 'N/A',
                    'Name Author' => $item->pemohon ? $item->pemohon->fullname : 'N/A',
                    'Nik Superior'         => $dataEmployeeSuperior[0]['EmpID'],
                    'Name Superior'         => $dataEmployeeSuperior[0]['EmployeeName'],
                    'Dept Superior'         => $dataEmployeeSuperior[0]['OrgGroupName'],

                    'No SOP'           => $item->sd_wi ?? 'NA',
                    'nomor'            => $item->nomor ?? 'NA',

                    'Kategori OPL' => $item->kategori->title ?? 'NA',
                    'mesin_id'         => $item->mesin->title ?? 'NA',
                    'tema'             => $item->tema ?? 'NA',
                    'tujuan'           => $item->tujuan ?? 'NA',
                    'fungsi'           => $item->fungsi ?? 'NA',
                    'prosedur'         => $item->prosedur ?? 'NA',
                    'dampak'           => $item->dampak ?? 'NA',
                    'distribusi'       => implode(', ', $item->distribusi),

                    // RND
                    'Kategori RnD'  => $item->kategoriRnd->title ?? 'NA',
                    'Visibility'       => strtoupper($item->umum ?? 'NA'),
                    'Tgl Buat'         => $item->created_at ? $item->created_at->format('l, d M Y H:i:s') : 'NA',
                ];
            });

            // Nama file
            $fileName = 'RnD_OPL_Report_' . now()->format('Ymd_His') . '.xlsx';

            // Simpan file ke storage sementara
            $filePath = storage_path('app/public/' . $fileName);
            (new FastExcel($formattedData))->export($filePath);

            // Kembalikan response download
            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('galat', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = OnePointLesson::find($id);
            if (empty($data)) {
                # code...
                return response()->json([
                    'success' => false,
                    'message' => 'OnePointLesson Tidak Tersedia'
                ]);
            }

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'DELETED',
                'catatan' => 'QualityRnD Menghapus OPL ' . $data->nomor
            ]);

            $data->delete();

            DB::commit();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil Menghapus OnePointLesson'
                ]
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(
                [
                    'success' => true,
                    'message' => $th->getMessage()
                ]
            );
        }
    }
}
