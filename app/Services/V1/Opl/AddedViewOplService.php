<?php

namespace App\Services\V1\Opl;

use App\Models\V1\OplView;
use App\Services\System\LogActivityService;

/**
 * Class AddedViewOplService.
 */
class AddedViewOplService
{
    public function handle($data)
    {
        // Cek apakah user sudah pernah melihat item ini
        $alreadyViewed = OplView::query()
            ->where('user', auth()->user()->email)
            ->where('opl_id', $data->id)
            ->exists();

        if (!$alreadyViewed) {
            // Simpan ke tabel item_views
            OplView::create([
                'user' => auth()->user()->email,
                'opl_id' => $data->id
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'VIEWED',
                'catatan' => 'Baru Saja Melihat OnePointLesson'
            ]);

            // Tambah view_count di table item (opsional)
            $data->increment('view_count');

            return true;
        }

        return false;
    }
}
