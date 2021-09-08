<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuruModel;
use Illuminate\Support\Facades\Redis;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->GuruModel = new GuruModel();
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'guru' => $this->GuruModel->allData(),
        ];
        return view('v_guru', $data);
    }
    public function detail($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        }
        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];
        return view('v_detailguru', $data);
    }
    public function add()
    {
        return view('v_addguru');
    }
    public function insert()
    {
        //Jika validasi tdk ada maka simpan data
        Request()->validate([
            'nip' => 'required|unique:tbl_guru,nip|min:4|max:5',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'required|mimes:jpg,jpeg,png|max:1024',
        ],[
            'nip.required' => 'Wajib diisi !!',
            'nip.unique' => 'NIP Ini Sudah Ada',
            'nip.min' => 'Min 4 Karakter',
            'nip.max' => 'Max 5 Karakter',
            'nama_guru.required' => 'Wajib diisi !!',
            'mapel.required' => 'Wajib diisi !!',
            'foto_guru.required' => 'Wajib diisi !!',
            ]);
            //upload data/foto
            $file = Request()->foto_guru;
            $fileName = Request()->nip.'.'. $file->extension();
            $file->move(public_path('foto_guru'), $fileName);

            $data = [
            'nip' => Request()->nip,
            'nama_guru' => Request()->nama_guru,
            'mapel' => Request()->mapel,
            'foto_guru' => $fileName,
        ];
        $this->GuruModel->addData($data);
        return redirect()->route('guru')->with('pesan','Data Berhasil di Tambahkan !!!');
    }
    public function edit($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        }
        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];
        return view('v_editguru', $data);
    }
    public function update($id_guru)
    {
        //Jika validasi tdk ada maka simpan data
        Request()->validate([
            'nip' => 'required|min:4|max:5',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'mimes:jpg,jpeg,png|max:1024',
        ],[
            'nip.required' => 'Wajib diisi !!',
            'nip.min' => 'Min 4 Karakter',
            'nip.max' => 'Max 5 Karakter',
            'nama_guru.required' => 'Wajib diisi !!',
            'mapel.required' => 'Wajib diisi !!',
            ]);
            if (Request()->foto_guru <> "") {
                //Jika ingin ganti foto
                //upload data/foto
                $file = Request()->foto_guru;
                $fileName = Request()->nip.'.'. $file->extension();
                $file->move(public_path('foto_guru'), $fileName);

                $data = [
                'nip' => Request()->nip,
                'nama_guru' => Request()->nama_guru,
                'mapel' => Request()->mapel,
                'foto_guru' => $fileName,
                ];
                $this->GuruModel->editData($id_guru, $data);
            }else {
                //Jika tidak ingin ganti foto
                $data = [
                    'nip' => Request()->nip,
                    'nama_guru' => Request()->nama_guru,
                    'mapel' => Request()->mapel,
                ];
                $this->GuruModel->editData($id_guru, $data);
            }
        return redirect()->route('guru')->with('pesan','Data Berhasil di Update !!!');
    }
    public function delete($id_guru)
    {
        //hapus atau delete foto
        $guru = $this->GuruModel->detailData($id_guru);
        if ($guru->foto_guru <> "") {
            unlink(public_path('foto_guru').'/'. $guru->foto_guru);
        }
        $this->GuruModel->deleteData($id_guru);
        return redirect()->route('guru')->with('pesan','Data Berhasil di Hapus !!!');
    }
}
