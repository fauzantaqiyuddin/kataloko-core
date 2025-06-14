<?php

namespace App\Traits;

use App\Models\System\AuditTrail;
use Illuminate\Support\Str;

trait AuditTrailable
{
    public static function bootAuditTrailable()
    {
        static::creating(function ($model) {
            // Generate UUID jika model belum memiliki UUID
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Simpan log saat data dibuat
            AuditTrail::create([
                'model' => get_class($model),
                'model_id' => $model->id,
                'action' => 'created',
                'new_data' => $model->getAttributes(),
                'user_id' => auth()->id(),
            ]);
        });

        static::updating(function ($model) {
            // Simpan log saat data diupdate
            AuditTrail::create([
                'model' => get_class($model),
                'model_id' => $model->id,
                'action' => 'updated',
                'old_data' => $model->getOriginal(),
                'new_data' => $model->getAttributes(),
                'user_id' => auth()->id(),
            ]);
        });

        static::deleting(function ($model) {
            // Simpan log saat data dihapus
            AuditTrail::create([
                'model' => get_class($model),
                'model_id' => $model->id,
                'action' => 'deleted',
                'old_data' => $model->getAttributes(),
                'user_id' => auth()->id(),
            ]);
        });
    }
}
