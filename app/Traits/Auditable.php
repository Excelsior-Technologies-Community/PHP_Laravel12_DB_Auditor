<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Auditable
{
    public static function bootAuditable()
    {
        // INSERT
        static::created(function ($model) {
            DB::table('audit_logs')->insert([
                'action' => 'INSERT',
                'table_name' => $model->getTable(),
                'new_data' => json_encode($model->toArray()),
                'created_at' => now(),
            ]);
        });

        // UPDATE
        static::updating(function ($model) {
            DB::table('audit_logs')->insert([
                'action' => 'UPDATE',
                'table_name' => $model->getTable(),
                'old_data' => json_encode($model->getOriginal()),
                'new_data' => json_encode($model->getDirty()),
                'created_at' => now(),
            ]);
        });

        // DELETE
        static::deleted(function ($model) {
            DB::table('audit_logs')->insert([
                'action' => 'DELETE',
                'table_name' => $model->getTable(),
                'old_data' => json_encode($model->toArray()),
                'created_at' => now(),
            ]);
        });
    }
}