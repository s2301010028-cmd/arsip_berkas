<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::orderBy('tanggal', 'desc')->get();
        return view('notice.index', compact('notices'));
    }

    public function apiIndex()
    {
        $notices = Notice::all()->map(function($notice) {
            $items = [];
            if ($notice->awal_pagi && $notice->akhir_pagi) {
                $items[] = [
                    'id' => $notice->id . '_1',
                    'tanggal' => $notice->tanggal,
                    'lokasi' => $notice->lokasi,
                    'shift' => 'Pagi',
                    'petugas' => $notice->petugas_pagi,
                    'awal' => $notice->awal_pagi,
                    'akhir' => $notice->akhir_pagi,
                    'jumlah' => $notice->jumlah_pagi,
                    'status' => $notice->status_pagi,
                    'keterangan' => $notice->keterangan_pagi,
                ];
            }
            if ($notice->awal_sore && $notice->akhir_sore) {
                $items[] = [
                    'id' => $notice->id . '_2',
                    'tanggal' => $notice->tanggal,
                    'lokasi' => $notice->lokasi,
                    'shift' => 'Sore',
                    'petugas' => $notice->petugas_sore,
                    'awal' => $notice->awal_sore,
                    'akhir' => $notice->akhir_sore,
                    'jumlah' => $notice->jumlah_sore,
                    'status' => $notice->status_sore,
                    'keterangan' => $notice->keterangan_sore,
                ];
            }
            return $items;
        })->flatten(1);
        
        return response()->json($notices);
    }

    public function create()
    {
        return view('notice.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
        ]);

        Notice::create([
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            
            // Shift Pagi (from camelCase form inputs)
            'petugas_pagi' => $request->petugasPagi,
            'awal_pagi' => $request->awalPagi,
            'akhir_pagi' => $request->akhirPagi,
            'jumlah_pagi' => $request->jumlahPagi ? (int)$request->jumlahPagi : null,
            'status_pagi' => $request->statusPagi,
            'keterangan_pagi' => $request->keteranganPagi,
            
            // Shift Sore
            'petugas_sore' => $request->petugasSore,
            'awal_sore' => $request->awalSore,
            'akhir_sore' => $request->akhirSore,
            'jumlah_sore' => $request->jumlahSore ? (int)$request->jumlahSore : null,
            'status_sore' => $request->statusSore,
            'keterangan_sore' => $request->keteranganSore,
        ]);

        return redirect()->route('arsip.index')->with('success', 'Data notice berhasil disimpan.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('notice.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
        ]);

        $notice = Notice::findOrFail($id);
        
        $notice->update([
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            
            'petugas_pagi' => $request->petugasPagi,
            'awal_pagi' => $request->awalPagi,
            'akhir_pagi' => $request->akhirPagi,
            'jumlah_pagi' => $request->jumlahPagi ? (int)$request->jumlahPagi : null,
            'status_pagi' => $request->statusPagi,
            'keterangan_pagi' => $request->keteranganPagi,
            
            'petugas_sore' => $request->petugasSore,
            'awal_sore' => $request->awalSore,
            'akhir_sore' => $request->akhirSore,
            'jumlah_sore' => $request->jumlahSore ? (int)$request->jumlahSore : null,
            'status_sore' => $request->statusSore,
            'keterangan_sore' => $request->keteranganSore,
        ]);

        return redirect()->route('arsip.index')->with('success', 'Data notice berhasil diupdate.');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();

        return redirect()->route('arsip.index')->with('success', 'Data notice berhasil dihapus.');
    }
}