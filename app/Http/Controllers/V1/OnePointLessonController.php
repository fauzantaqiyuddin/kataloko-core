<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\System\UserPrint;
use App\Models\V1\CategoryRnd;
use App\Models\V1\CategoryUmum;
use App\Models\V1\ImageOpl;
use App\Models\V1\Invitation;
use App\Models\V1\Machine;
use App\Models\V1\OnePointLesson;
use App\Models\V1\Sosialisasi;
use App\Services\Dept\MasterDeptService;
use App\Services\System\ApprovalMailService;
use App\Services\System\GetHrisEmployeeService;
use App\Services\System\LogActivityService;
use App\Services\System\SendInviteMailService;
use App\Services\System\UploadToMinioService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;

class OnePointLessonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->where([
                    'user' => auth()->user()->email,
                ])
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

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    if ($row->progress == 501) {
                        # code...
                        $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="avtar avtar-s btn-link-primary inviteMail"><i class="ti ti-mail f-20"></i></a>';
                    } else {
                        # code...
                        $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" class="avtar avtar-s btn-link-primary"><i class="ti ti-x f-20"></i></a>';
                    }

                    $btn_2 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('v1.onePointLesson.destroy', $row->id) . '" data-original-title="distribusi" class="avtar avtar-s btn-link-warning distribusi"><i class="ti ti-mailbox f-20"></i></a>';
                    $btn_3 = $btn_2 . '<a href="' . route('v1.onePointLesson.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info"><i class="ti ti-eye f-20"></i></a>';
                    $btn = $btn_1 . $btn_3 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('v1.onePointLesson.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action', 'publishnya', 'approvalnya', 'atasan'])
                ->make(true);
        }
        return view('v1.opl.operator.index');
    }

    public function getDistribusiDept(Request $request)
    {
        $dept = (new MasterDeptService)->handle();
        return response()->json($dept);
    }

    public function create()
    {
        $category = CategoryUmum::latest()->get();
        $mesin = Machine::latest()->get();
        $rnd = CategoryRnd::latest()->get();
        $dept = (new MasterDeptService)->handle();
        // dd($dept);

        return view('v1.opl.operator.create', compact('category', 'mesin', 'rnd', 'dept'));
    }

    public function getHrisEmployee(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $groupCode = auth()->user()->groupKode;
            return (new GetHrisEmployeeService)->handle($request, $groupCode);
        }
    }

    public function store(Request $request)
    {
        if ($request->draft == 'enabled') {
            # code...
            $request->validate([
                'category' => 'required',
                'tema' => 'required',
                'fasilitator' => 'required'
            ]);

            try {
                DB::beginTransaction();

                Onepointlesson::create([
                    'user' => auth()->user()->email,
                    'category_umum_id' => $request->category,
                    'category_rnd_id' => $request->rnd ?? null,
                    'mesin_id' => $request->mesin ?? null,
                    'supervisor' => $request->fasilitator,
                    'tema' => $request->tema,
                    'tujuan' => $request->tujuan ?? null,
                    'fungsi' => $request->fungsi ?? null,
                    'prosedur' => $request->prosedur ?? null,
                    'dampak' => $request->dampak ?? null,
                    'sdwi' => $request->sd_wi ?? null,
                    // 'nomor' => 'OPL/XII/2024/MSTD.001',
                    'status' => 'draft',
                    'progress' => 100
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Menyimpan OPL Menjadi Draft',
                    'redirect' => route('v1.opl.index')
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
        } else {
            # code...
            $isRandD =
                isset(auth()->user()->result['DivName']) &&
                preg_match('/R\s*&\s*D/i', auth()->user()->result['DivName']);

            if ($isRandD) {
                # code...
                $request->validate([
                    'category'        => 'required',
                    'tema'            => 'required',
                    'fasilitator'     => 'required',
                    'tujuan'          => 'required',
                    'fungsi'          => 'required',
                    'prosedur'        => 'required',
                    'dampak'          => 'required',
                    'umum'            => 'required',
                    'category_rnd'    => 'required',
                ], [
                    'category.required'      => 'Kategori wajib diisi.',
                    'tema.required'          => 'Tema wajib diisi.',
                    'fasilitator.required'   => 'Fasilitator wajib diisi.',
                    'tujuan.required'        => 'Tujuan wajib diisi.',
                    'fungsi.required'        => 'Fungsi wajib diisi.',
                    'prosedur.required'      => 'Prosedur wajib diisi.',
                    'dampak.required'        => 'Dampak wajib diisi.',
                    'umum.required'          => 'Informasi umum wajib diisi.',
                    'category_rnd.required'  => 'Kategori RnD wajib diisi.',
                ]);

                $khususRule = Validator::make($request->all(), [
                    'image.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'descImage.*'     => 'required_with:image.*|string|max:255',
                    'distribusi' => 'required|array|min:1',
                    'distribusi.*' => 'string|max:255',
                ], [
                    // Validasi gambar dan deskripsi
                    'image.*.image'          => 'File harus berupa gambar.',
                    'image.*.mimes'          => 'Gambar harus berformat: jpeg, png, jpg, atau gif.',
                    'image.*.max'            => 'Ukuran gambar maksimal 2MB.',
                    'descImage.*.required_with' => 'Deskripsi harus diisi jika gambar diunggah.',
                    'descImage.*.string' => 'Deskripsi harus diisi',
                    'distribusi.required' => 'Minimal satu distribusi harus dipilih.',
                    'distribusi.array' => 'Format distribusi tidak valid.',
                    'distribusi.*.string' => 'Setiap distribusi harus berupa teks.',
                ]);

                if ($khususRule->fails()) {
                    // Ambil semua error dan tambahkan nomor urut untuk setiap error
                    $errorsWithIndex = [];
                    foreach ($khususRule->errors()->getMessages() as $field => $messages) {
                        // Mengecek apakah field adalah distribusi
                        if (strpos($field, 'distribusi') === false) {
                            // Mendapatkan nomor urut berdasarkan index
                            preg_match_all('/\d+/', $field, $matches);
                            $index = isset($matches[0][0]) ? $matches[0][0] : null; // Mengambil nomor index

                            // Menambahkan 1 agar index dimulai dari 1
                            if ($index !== null) {
                                $index = $index + 1;
                            }

                            // Menambahkan pesan error dengan nomor input
                            foreach ($messages as $message) {
                                $errorsWithIndex[] = "Input ke-$index: $message";
                            }
                        } else {
                            // Jika field adalah distribusi, tidak tambahkan nomor input
                            foreach ($messages as $message) {
                                $errorsWithIndex[] = $message;
                            }
                        }
                    }

                    return response()->json([
                        'success' => false,
                        'message' => implode(', ', $errorsWithIndex)
                    ]); // tanpa status 422 (pakai 200)
                }
            } else {
                # code...
                $request->validate([
                    'category' => 'required',
                    'tema' => 'required',
                    'fasilitator' => 'required',
                    'tujuan' => 'required',
                    'fungsi' => 'required',
                    'prosedur' => 'required',
                    'dampak' => 'required',

                    'image' => 'array',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'descImage' => 'required|array',
                    'descImage.*' => 'nullable|string|max:1000',
                ]);
            }


            try {
                DB::beginTransaction();
                $opl = Onepointlesson::create([
                    'user' => auth()->user()->email,
                    'category_umum_id' => $request->category,
                    'mesin_id' => $request->mesin,
                    'supervisor' => $request->fasilitator,
                    'tema' => $request->tema,
                    'tujuan' => $request->tujuan,
                    'fungsi' => $request->fungsi,
                    'prosedur' => $request->prosedur,
                    'dampak' => $request->dampak,
                    'sdwi' => $request->sd_wi ?? null,
                    // 'nomor' => 'OPL/XII/2024/MSTD.001',
                    'status' => 'publish',
                    'progress' => 101,
                    'distribusi' => $request->distribusi,

                    // RND
                    'category_rnd_id' => $request->category_rnd ?? null,
                    'umum' => $request->umum ?? 'public'
                ]);

                (new LogActivityService)->handle([
                    'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                    'user' => strtoupper(auth()->user()->email),
                    'tindakan' => 'CREATED',
                    'catatan' => 'Berhasil Membuat OnePointLesson Baru'
                ]);

                if ($request->has('descImage') && is_array($request->descImage)) {
                    foreach ($request->descImage as $key => $descImage) {
                        // Proses gambar
                        $imagePath = isset($request->image[$key]) && $request->image[$key] != null
                            ? (new UploadToMinioService)->handle($request->image[$key], 'opl')
                            : asset('assets/images/no_image.png');

                        // Simpan ke database
                        ImageOpl::create([
                            'user' => auth()->user()->email,
                            'opl_id' => $opl->id,
                            'image' => $imagePath,
                            'deskripsi' => $descImage ?: 'NO Description'
                        ]);
                    }
                }

                $message = 'Halo anda baru saja menerima permintaan persetujuan OnePointLesson yang telah dibuat oleh ' . auth()->user()->fullname . ' Silahkan lakukan persetujuan segera.';
                $params = [
                    'status' => 'Approval Superior',
                    'link' => route('v1.approval.superior.show', $opl->id),
                    'penerima' => strstr($request->fasilitator, '@', true),
                    'body' => $message
                ];

                (new ApprovalMailService)->handle($request->fasilitator, $params);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Mengirim OPL Kepada Superior',
                    'redirect' => route('v1.onePointLesson.index')
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
        }
    }

    public function storeDistribusiDept(Request $request)
    {
        $data = OnePointLesson::find($request->idDistribusi);
        if (empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'OnePointLesson Tidak Ada'
            ]);
        }

        try {
            DB::beginTransaction();
            $data->update([
                'distribusi' => $request->distribusiDept
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'UPDATED',
                'catatan' => 'Berhasil Update Daftar Distribusi'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Data Distribusi'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            # code...
            return response()->json(OnePointLesson::find($id));
        }

        $data = Onepointlesson::query()
            ->with('mesin', 'lampiran', 'sosialisasi', 'sosialisasiPublish', 'kategoriRnd')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('admin.masterOPL.index')->with('galat', 'OPL Tidak Ditemukan');
        }

        if ($data->status == 'draft') {
            # code...
            $category = CategoryUmum::latest()->get();
            $mesin = Machine::latest()->get();
            return view('v1.opl.operator.edit', compact('data', 'category', 'mesin'));
        } else {
            # code...

            if (in_array($data->progress, [102, 202])) {
                # return 
                $category = CategoryUmum::latest()->get();
                $mesin = Machine::latest()->get();
                $rnd = CategoryRnd::latest()->get();
                return view('v1.opl.operator.edit', compact('data', 'category', 'mesin', 'rnd'));
            } else {
                # code...
                $category = CategoryUmum::latest()->get();
                // $sosialisasi = Sosialisasi::where('opl_id', $data->id)->get();
                // dd($sosialisasi);
                return view('v1.opl.operator.show', compact('data', 'category'));
            }
        }
    }

    public function ajaxSosialisasi($id, Request $request)
    {
        if ($request->ajax()) {
            $data = Onepointlesson::query()
                ->find($id);
            $sosialisasi = Sosialisasi::query()
                ->where('opl_id', $data->id)
                ->select(['tgl_training', 'traine', 'sign_traine', 'trainer', 'sign_trainer', 'status'])
                ->orderBy('created_at', 'DESC');
            return DataTables::of($sosialisasi)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) use ($request) {
                    static $index = 1;
                    $start = $request->start ?? 0;
                    return $start + $index++;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 'aprove') {
                        # code...
                        return 'Complated';
                    } else {
                        # code...
                        return 'Not Approval';
                    }
                })

                ->rawColumns(['action', 'tgl_sosialisasi'])
                ->make(true);
        }
    }

    public function printPdf($id)
    {
        // Periksa apakah user sudah memiliki record di tabel user_print
        $userPrint = UserPrint::firstOrCreate(['user_id' => auth()->user()->id]);
        $userPrint->increment('print_count');
        $cetakanKe = $userPrint->print_count;
        $category = CategoryUmum::latest()->get();

        $data = OnePointLesson::query()
            ->find($id);

        if ($data->progress < 501) {
            # code...
            return back()->with('galat', 'Silahkan Selesaikan Dahulu');
        }

        if (empty($data)) {
            # code...
            return redirect()->route('v1.onePointLesson.index')->with('galat', 'Tidak Ada Data');
        }

        $creator = $data->pemohon->fullname;
        $title = 'OPL-' . $data->nomor . '-' . time() . '.pdf';

        $pdf = Pdf::loadView('v1.opl.operator.printPdf', compact('data', 'cetakanKe', 'creator', 'category', 'title'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // Tambahkan page_text lewat callback (DomPDF)
        $pdf->getDomPDF()->get_canvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($cetakanKe) {
            $font = $fontMetrics->get_font('helvetica', 'italic');
            $size = 7;
            $color = [0, 0, 0];

            // Posisi kanan bawah
            $canvas->text(
                $canvas->get_width() - 72,
                $canvas->get_height() - 30,
                "Halaman $pageNumber dari $pageCount",
                $font,
                $size,
                $color
            );

            // Posisi kiri bawah
            $user = auth()->user()->fullname ?? 'Sistem';
            $dateText = "Diprint Oleh $user, Cetakan Ke-$cetakanKe";
            $canvas->text(
                18,
                $canvas->get_height() - 30,
                $dateText,
                $font,
                $size,
                $color
            );

            // Teks tambahan di bawahnya
            $appTitle = env('TITLE_APP', 'Aplikasi'); // fallback jika APP_TITLE tidak ada
            $footerNote = "Dokumen ini dicetak secara elektronik dari $appTitle";
            $canvas->text(
                18,
                $canvas->get_height() - 20, // sedikit lebih ke atas agar tidak nabrak tepi bawah
                $footerNote,
                $font,
                $size,
                $color
            );
        });

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"$title\"");
    }

    public function destroy($id)
    {
        $data = OnePointLesson::find($id);
        if (empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'OnePointLesson Tidak Tersedia'
            ]);
        }

        if ($data->progress == 501) {
            # code...
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Tidak Bisa Menghapus karena Sudah Publish'
                ]
            );
        } else {
            $data->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil Menghapus OnePointLesson'
                ]
            );
        }
    }

    public function update($id, Request $request)
    {
        $isRandD =
            isset(auth()->user()->result['DivName']) &&
            preg_match('/R\s*&\s*D/i', auth()->user()->result['DivName']);

        if ($isRandD) {
            # code...
            $request->validate([
                'tema' => 'required',
                'category' => 'required',
                'tujuan' => 'required',
                'fungsi' => 'required',
                'prosedur' => 'required',
                'dampak' => 'required'
            ]);
        } else {
            # code...
            $request->validate([
                'category' => 'required',
                'tema' => 'required',
                'tujuan' => 'required',
                'fungsi' => 'required',
                'prosedur' => 'required',
                'dampak' => 'required',
            ]);
        }

        $data = OnePointLesson::find($id);
        if (empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'OnepointLesson Tidak tersedia'
            ]);
        }

        try {
            DB::beginTransaction();
            $data->update([
                'category_umum_id' => $request->category,
                'mesin_id' => $request->mesin,
                'tema' => $request->tema,
                'tujuan' => $request->tujuan,
                'fungsi' => $request->fungsi,
                'prosedur' => $request->prosedur,
                'dampak' => $request->dampak,
                'sdwi' => $request->sd_wi ?? null,
                'status' => 'publish',
                'progress' => 101,
                // RND
                'category_rnd_id' => $request->category_rnd ?? null
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'UPDATED',
                'catatan' => 'Berhasil Mengupdate OnePointLesson'
            ]);

            $message = 'Halo anda baru saja menerima permintaan persetujuan OnePointLesson yang telah dibuat oleh ' . auth()->user()->fullname . ' Silahkan lakukan persetujuan segera.';
            $params = [
                'status' => 'Approval Superior',
                'link' => route('v1.approval.superior.show', $data->id),
                'penerima' => strstr($data->supervisor, '@', true),
                'body' => $message
            ];

            (new ApprovalMailService)->handle($data->supervisor, $params);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Mengirim OPL Kepada Superior',
                'redirect' => route('v1.onePointLesson.index')
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function approvalSosialisasi($id, $id_sosialisasi, Request $request)
    {
        $data = Sosialisasi::where([
            'opl_id' => $id,
            'id' => $id_sosialisasi
        ])->first();

        try {
            DB::beginTransaction();

            if ($request->status == 'setuju') {
                $data->update([
                    'status' => 'aprove',
                    'sign_trainer' => now()
                ]);

                (new LogActivityService)->handle([
                    'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                    'user' => strtoupper(auth()->user()->email),
                    'tindakan' => 'APROVED',
                    'catatan' => $data->traine . ' Berhasil Disetujui Mengikuti Sosialisasi'
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $data->traine . ' Berhasil Disetujui Mengikuti Sosialisasi'
                ]);
            } else {
                $data->update([
                    'status' => 'reject',
                ]);

                (new LogActivityService)->handle([
                    'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                    'user' => strtoupper(auth()->user()->email),
                    'tindakan' => 'APROVED',
                    'catatan' => $data->traine . ' Tidak Disetujui Mengikuti Sosialisasi'
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $data->traine . ' Tidak Disetujui Mengikuti Sosialisasi'
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function sendInviteMail(Request $request)
    {
        try {
            $data = OnePointLesson::find($request->id);

            $email = $request->email;
            $password = $this->generateRandomPassword();
            $passwordHash = Hash::make($password);
            $expired = null;

            switch ($request->expired) {
                case 'monthly':
                    $expired = now()->addMonth();
                    break;
                case 'yearly':
                    $expired = now()->addYear();
                    break;
                case 'permanent':
                    $expired = null;
                    break;
            }

            $link = Invitation::create([
                'opl_id' => $data->id,
                'password' => $passwordHash,
                'email' => $request->email,
                'expired' => $expired
            ]);

            $params = [
                'tema' => $data->tema,
                'expired' => $expired ? Carbon::parse($expired)->translatedFormat('l, d M Y') : 'Waktu Yang Tidak Ditentukan',
                'password' => $password,
                'fullname' => $request->email,
                'link' => route('guestMode', $link->id)
            ];


            (new SendInviteMailService)->handle($params, $email);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Mengirim Undangan OnePointLesson'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function generateRandomPassword()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $maxIndex = strlen($characters) - 1;
        $length = 5;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $maxIndex)];
        }

        return $password;
    }

    public function exportExcel()
    {
        try {
            $data = OnePointLesson::query()
                ->with('mesin', 'lampiran', 'sosialisasi', 'sosialisasiPublish', 'kategoriRnd', 'kategori')
                ->where([
                    'user' => auth()->user()->email,
                ])
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
            $fileName = 'one_point_lesson_export_' . now()->format('Ymd_His') . '.xlsx';

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
}
