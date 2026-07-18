<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::count();
        $department = Department::count();
        $payroll = Payroll::count();

        // Logika Filter Berdasarkan Role
        if (session('role') == 'HR') {
            // Jika HR: Ambil semua data kehadiran dan semua tugas
            $presence = Presence::count();
            $tasks = Task::all();
        } else {
            // Jika Karyawan:
            // 1. Ambil jumlah kehadiran milik sendiri
            $presence = Presence::where('employee_id', session('employee_id'))
                ->where('status', 'present')
                ->count();

            // 2. Ambil tugas yang HANYA dimiliki oleh karyawan yang sedang login
            // Kita memfilter tabel 'tasks' lewat relasi 'employee' yang ada di model Task
            $tasks = Task::whereHas('employee', function ($query) {
                $query->where('id', session('employee_id'));
                // Catatan: Jika primary key di tabel employees Anda bukan 'id' (misal: 'employee_id'),
                // ganti 'id' di atas dengan nama primary key yang sesuai.
            })->get();
        }
        return view('dashboard.index', compact('employee', 'department', 'payroll', 'presence', 'tasks'));
    }

    public function presence()
    {
        // $data = Presence::where('status', 'present')
        //     ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
        //     ->groupBy('year', 'month')
        //     ->orderBy('month', 'asc') // Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec
        //     ->get();

        // $temp = [];
        // $i = 0;

        // foreach ($data as $item) {
        //     $temp[$i] = $item->total_present;
        //     $i++;
        // }

        // return response()->json($temp);

        // 1. Cek Hak Akses Role
        if (session('role') == 'HR') {
            // Jika HR: Hitung absensi 'present' dari SELURUH karyawan pada tahun ini
            $data = Presence::where('status', 'present')
                ->whereYear('date', date('Y'))
                ->selectRaw('EXTRACT(MONTH FROM date) as month, COUNT(*) as total_present')
                ->groupBy('month')
                ->pluck('total_present', 'month');
        } else {
            // Jika Karyawan Biasa: Hanya hitung absensi milik 'employee_id' yang sedang login
            $data = Presence::where('status', 'present')
                ->whereYear('date', date('Y'))
                ->where('employee_id', session('employee_id'))
                ->selectRaw('EXTRACT(MONTH FROM date) as month, COUNT(*) as total_present')
                ->groupBy('month')
                ->pluck('total_present', 'month');
        }

        // 2. Mapping Data ke Array untuk Chart.js (Ubah batas ke 12 untuk Januari - Desember)
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[] = $data->get($month, 0);
        }

        // 3. Kembalikan data dalam bentuk JSON bersih ke JavaScript Fetch
        return response()->json($monthlyData);
    }
}
