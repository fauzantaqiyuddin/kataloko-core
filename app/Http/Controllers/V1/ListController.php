<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\OnePointLesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = OnePointLesson::select(['tema', 'user', 'umum', 'created_at'])
                ->orderBy('created_at', 'DESC');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) use ($request) {
                    static $index = 1;
                    $start = $request->start ?? 0;
                    return $start + $index++;
                })
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('l, d F Y H:i');
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $keyword = $request->search['value'];
                        $query->where(function ($q) use ($keyword) {
                            $q->where('user', 'like', "%{$keyword}%")
                                ->orWhere('tema', 'like', "%{$keyword}%");
                        });
                    }
                })
                ->orderColumn('tanggal', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->make(true);
        }

        return view('v1.listOpl.index');
    }
}
