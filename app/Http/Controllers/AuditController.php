<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    // Audit logs + dashboard + chart
    public function index(Request $request)
    {
        $logs = DB::table('audit_logs')
            ->when($request->action, function ($query) use ($request) {
                $query->where('action', $request->action);
            })
            ->orderBy('id', 'asc')
            ->paginate(3);

        $stats = [

            'total_logs' => DB::table('audit_logs')->count(),

            'insert' => DB::table('audit_logs')
                ->where('action', 'INSERT')
                ->count(),

            'update' => DB::table('audit_logs')
                ->where('action', 'UPDATE')
                ->count(),

            'delete' => DB::table('audit_logs')
                ->where('action', 'DELETE')
                ->count(),
        ];


        $chartData = [

            DB::table('audit_logs')
                ->where('action', 'INSERT')
                ->count(),

            DB::table('audit_logs')
                ->where('action', 'UPDATE')
                ->count(),

            DB::table('audit_logs')
                ->where('action', 'DELETE')
                ->count(),
        ];


        return view(
            'audit.index',
            compact(
                'logs',
                'stats',
                'chartData'
            )
        );
    }


    // Export CSV
    public function export()
    {
        $fileName = 'audit_logs.csv';

        $logs = DB::table('audit_logs')->get();

        $headers = [

            "Content-type" => "text/csv",

            "Content-Disposition" =>
            "attachment; filename={$fileName}",

            "Pragma" => "no-cache",

            "Cache-Control" => "must-revalidate"
        ];


        $callback = function () use ($logs) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [

                'ID',
                'Action',
                'Table',
                'Old Data',
                'New Data',
                'Created At'

            ]);

            foreach ($logs as $log) {

                fputcsv($file, [

                    $log->id,
                    $log->action,
                    $log->table_name,
                    $log->old_data,
                    $log->new_data,
                    $log->created_at

                ]);
            }

            fclose($file);
        };

        return response()
            ->stream(
                $callback,
                200,
                $headers
            );
    }
}
