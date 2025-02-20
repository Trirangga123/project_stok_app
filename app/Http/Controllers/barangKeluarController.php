<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\pelanggan;
use App\Models\stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangKeluarController extends Controller
{

    public function index()
    {
        return view('Barang.BarangKeluar.Barangkeluar');
    }
    public function create()
    {
        $data = BarangKeluar::all();

        $lastid = BarangKeluar::max('id');
        $lastid = $lastid ? $lastid : 0; //ternary operator

        if ($data->isEmpty()){
            $nextId = $lastid + 1;
            $date = now()->format('d/m/Y');
            $kode_transaksi = 'TRK'. $nextId . '/' . $date;

            $pelanggan = pelanggan::all();


            return view('Barang.BarangKeluar.add-Barangkeluar', compact(
                'data',
                'kode_transaksi',
                'pelanggan'
            ));
        }

        $latestItem = barangKeluar::latest()->first();
        $id = $latestItem->id;
        $date = $latestItem->created_at->format('d/m/Y');
        $kode_transaksi = 'TRK'. ($id+1). '/' . $date;
        $pelanggan = pelanggan::all();









        return view('Barang.BarangKeluar.add-Barangkeluar', compact(
            'data',
            'kode_transaksi',
            'pelanggan'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tgl_faktur'        =>'required',
            'tgl_jatuh_tempo'   =>'required',
            'pelanggan_id'      => 'required',
            'jenis_pembayaran'  => 'required',

        ], [
            'tgl_faktur    . required' =>'Data wajib diisi!',
            'tgl_jatuh_tempo.required' =>'Data wajib diisi!',
            'pelanggan_id  . required' =>'Data wajib diisi!',
            'jenis_pembayaran.required'=>'Data wajib diisi!',

        ]);

        $kode_transaksi = $request->kode_transaksi;
        $tgl_faktur = $request->tgl_faktur;
        $tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $pelanggan_id = $request->pelanggan_id;

        $getnamePelanggan = pelanggan::find($pelanggan_id);
        $namePelanggan = $getnamePelanggan->nama_pelanggan;
        $jenis_pembayaran = $request->jenis_pembayaran;

        $getBarang = stok::all();

        return view('Transaksi.Transaksi', compact(
            'kode_transaksi',
            'tgl_faktur',
            'tgl_jatuh_tempo',
            'pelanggan_id',
            'namePelanggan',
            'jenis_pembayaran',
            'getBarang',
        ));



    }

    public function savebarangKeluar(Request $request)
    {
        $request->validate([
            'kode_transaksi'    => 'required',
            'tgl_faktur'        => 'required',
            'tgl_jatuh_tempo'   => 'required',
            'pelanggan_id'      => 'required',
            'jenis_pembayaran'  => 'required',
            'barang-id'         => 'required',
            'jumlah_beli'       => 'required',
            'harga_jual'        => 'required',


        ]);

        $save = new BarangKeluar();
        $save->kode_transaksi = $request->kode_transaksi;
        $save->tgl_faktur = $request->tgl_faktur;
        $save->tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $save->pelanggan_id = $request->pelanggan_id;
        $save->jenis_pembayaran = $request->jenis_pembayaran;
        $save->barang_id = $request->barang_id;
        $save->jumlah_beli = $request->dsvsvsdfsdf;
        $save->harga_jual = $request->harga_jual;

            $getStokData = stok::find($request->barang_id);
                $getJumlahStok = $getStokData->stok;
            $getStokData->stok = $getJumlahStok - $request->jumlah_beli;
            $getStokData->save();

        $diskon = $request->diskon;
           $nilaiDiskon = $diskon/100;

        if ($diskon) {
            $save->diskon = $request->diskon;
                 $hitung = $request->jumlah_beli * $request->harga_jual;
                 $totalDiskon  = $hitung * $nilaiDiskon;
                 $subTotal = $hitung - $totalDiskon;
            $save->sub_total = $totalDiskon;
        } else {
            $hitung = $request->jumlah_beli * $request->harga_jual;
            $save->sub_total = $hitung;
        }

        $save->user_id = Auth::user()->id;
        $save->tgl_buat = $request->tgl_faktur;
        $save->save();

        return redirect('/barang-keluar')->with(
            'message',
            'Barang keluar add'
        );





    }






    // tgl_faktur
    // tgl_jatuh_tempo
    // pelanggan_id
    // jenis_pembayaran
    // barang_id
    // jumlah_beli
    // harga_jual
    // diskon
    // sub_total
    // user_id
    // tgl_buat

}
