<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanM;
use Illuminate\Http\Request;
use App\Http\Resources\PeminjamanR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeminjamanC extends Controller
{
    public function index()
    {
        $peminjaman = PeminjamanM::latest()->paginate(5);
        return new PeminjamanR(true, 'List Data Peminjaman', $peminjaman);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_buku' => 'required',
            'id_user' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
            'denda' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $peminjaman = PeminjamanM::create([
            'id_buku' => $request->id_buku,
            'id_user' => $request->id_user,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $request->denda,
        ]);

        return new PeminjamanR(true, 'Data Peminjaman Berhasil Ditambahkan!', $peminjaman);
    }

    public function show(PeminjamanM $peminjaman){
        return new PeminjamanR(true, 'Data Peminjaman Ditemukan!', $peminjaman);
    }

    public function update(Request $request, PeminjamanM $peminjaman){
        $validator = Validator::make($request->all(),[
            'id_buku' => 'required',
            'id_user' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
            'denda' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $peminjaman->update([
            'id_buku' => $request->id_buku,
            'id_user' => $request->id_user,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $request->denda,
        ]);

        return new PeminjamanR(true, 'Data Berhasil Diubah!', $peminjaman);
    }

    public function destroy(PeminjamanM $peminjaman){
        Storage::delete('public/peminjaman/'.$peminjaman);

        $peminjaman->delete();

        return new PeminjamanR(true, 'Data Peminjaman Berhasil Dihapus!', null);
    }
}
