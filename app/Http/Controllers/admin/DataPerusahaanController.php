<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\PerusahaanImport;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DataPerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'asc')->get();

        return view('layouts.admin.data.dataPerusahaan', compact('perusahaan'));
    }

    public function search(Request $request)
    {
        $search = $request->q;

        $data = Perusahaan::where('nama_perusahaan', 'like', "%$search%")
            ->select('id', 'nama_perusahaan as text')
            ->limit(5)
            ->get();

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $perusahaan->update($request->all());

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        Perusahaan::findOrFail($id)->delete();

        return response()->json(['status' => 'success']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string|max:255|unique:perusahaan,nama_perusahaan',
            'bidang_usaha'    => 'nullable|string|max:255',
            'email'           => 'nullable|email',
            'no_telepon'      => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'status_mitra'    => 'required|in:mitra,non_mitra',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'nama_perusahaan.unique'   => 'Perusahaan sudah terdaftar.',
            'email.email'              => 'Format email tidak valid.',
            'status_mitra.required'    => 'Silakan pilih status mitra.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        Perusahaan::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Perusahaan berhasil ditambahkan.'
        ]);
    }

    public function import(Request $request)
    {
        // validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        try {
            $import = new PerusahaanImport();

            Excel::import($import, $request->file('file'));

            $result = $import->getReport();

            return redirect()->back()->with([
                'import_success' => count($result['success']),
                'import_failed'  => count($result['failed']),
                'failed_list'    => $result['failed']
            ]);
        } catch (\Throwable $e) {

            return redirect()->back()->with(
                'error',
                'Terjadi kesalahan saat import: ' . $e->getMessage()
            );
        }
    }
}
