<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function historyAttendance()
    {
        // Pastikan user sudah login
        if (!Session::has('api_token')) {
            return redirect('/login')->withErrors(['nrp' => 'Silakan login terlebih dahulu.']);
        }

        $token = Session::get('api_token');
        
        try {
            // Fetch dari API Node.js (Endpoint GET /history untuk riwayat user login)
            $response = \Illuminate\Support\Facades\Http::withToken($token)->get('http://localhost:3000/api/attendance/history');

            if ($response->successful()) {
                $attendances = $response->json();
            } else {
                $attendances = []; // Fallback jika server terputus
            }
        } catch (\Exception $e) {
            $attendances = []; // Tangkap dan selimuti error jaringan server
        }
        
        return view('report.history', compact('attendances'));
    }

    public function exportExcel()
    {
        if (!Session::has('api_token')) {
            return redirect('/login');
        }

        $token = Session::get('api_token');
        try {
            // Ambil data terbaru dari Node.js untuk di export
            $response = \Illuminate\Support\Facades\Http::withToken($token)->get('http://localhost:3000/api/attendance/history');
            $attendances = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $attendances = [];
        }

        $fileName = "Report_History_Attendance_" . date('Ymd') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Attendance Date', 'Attendance Hour', 'NRP', 'Nama Lengkap', 
            'Distrik', 'Posisi', 'Divisi', 'Trans', 'Lokasi', 'CP Location', 'Att Location'
        ];

        $callback = function() use($attendances, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM untuk kompabilitas Excel agar membaca karakter khusus dengan benar
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Gunakan separator titik koma (;) agar lebih natural terbuka berlajur di Excel Indonesia/Windows
            fputcsv($file, $columns, ';');
            
            foreach ($attendances as $row) {
                $waktuAbsen = isset($row['time_wita']) ? \Carbon\Carbon::parse($row['time_wita'])->format('H:i:s') : '-';
                $tanggalAbsen = isset($row['attendance_date']) ? \Carbon\Carbon::parse($row['attendance_date'])->format('Y-m-d') : '-';
                
                $isCheckIn = ($row['trans_type'] ?? '') === 'Check_in';
                $transLabel = $isCheckIn ? 'IN' : 'OUT';

                $namaKaryawan = $row['employee']['full_name'] ?? session('user.employee_data.full_name') ?? session('user.nrp') ?? '-';
                
                fputcsv($file, [
                    $tanggalAbsen,
                    $waktuAbsen,
                    $row['nrp'] ?? '-',
                    $namaKaryawan,
                    $row['employee']['mitra_kerja']['mitra_kerja_name'] ?? '-',
                    $row['employee']['position']['pos_name'] ?? '-',
                    $row['employee']['division']['div_name'] ?? '-',
                    $transLabel,
                    $row['work_location'] ?? 'WFO',
                    $row['cp_location'] ?? '-',
                    isset($row['att_latitude']) ? round($row['att_latitude'], 4) . ',' . round($row['att_longitude'], 4) : '-'
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- GEOFENCE LOCATION MANAGEMENT ---
    public function geofence()
    {
        if (!Session::has('api_token')) return redirect('/login');

        try {
            $response = \Illuminate\Support\Facades\Http::withToken(Session::get('api_token'))
                ->get('http://localhost:3000/api/master/mitra-kerja');
            $locations = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $locations = [];
        }

        return view('report.geofence', compact('locations'));
    }

    public function updateGeofence(Request $request, $id)
    {
        if (!Session::has('api_token')) return redirect('/login');

        try {
            $response = \Illuminate\Support\Facades\Http::withToken(Session::get('api_token'))
                ->put("http://localhost:3000/api/master/mitra-kerja/{$id}", [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius_meters' => $request->radius_meters,
            ]);
            
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Lokasi target geofence berhasil diperbarui!');
            }
            return redirect()->back()->withErrors(['error' => 'Gagal mengubah geofence. (Node.js Response: ' . $response->body() . ')']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Koneksi ke backend terputus. API Node.js mati?']);
        }
    }

    public function storeGeofence(Request $request)
    {
        if (!Session::has('api_token')) return redirect('/login');

        try {
            $response = \Illuminate\Support\Facades\Http::withToken(Session::get('api_token'))
                ->post("http://localhost:3000/api/master/mitra-kerja", [
                'mitra_kerja_name' => $request->mitra_kerja_name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius_meters' => $request->radius_meters,
            ]);
            
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Lokasi target geofence baru berhasil ditambahkan!');
            }
            return redirect()->back()->withErrors(['error' => 'Gagal menambah geofence. (Node.js Response: ' . $response->body() . ')']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Koneksi ke backend terputus. API Node.js mati?']);
        }
    }

    public function destroyGeofence($id)
    {
        if (!Session::has('api_token')) return redirect('/login');

        try {
            $response = \Illuminate\Support\Facades\Http::withToken(Session::get('api_token'))
                ->delete("http://localhost:3000/api/master/mitra-kerja/{$id}");
            
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Lokasi geofence berhasil dihapus secara permanen!');
            }
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus geofence. (Node.js Response: ' . $response->body() . ')']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Koneksi ke backend terputus. API Node.js mati?']);
        }
    }
}
