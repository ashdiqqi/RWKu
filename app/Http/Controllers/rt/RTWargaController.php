<?php

namespace App\Http\Controllers\rt;
use App\Http\Controllers\Controller;


use App\Models\RTModel;
use App\Models\UserModel;
use App\Models\WargaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class RTWargaController extends Controller
{
    // Menampilkan halaman awal level
    public function index()
    {
        // Set the breadcrumb data
        $breadcrumb = (object) [
            'title' => 'Daftar Warga',
            'list' => ['Home', 'Warga']
        ];

        // Set the page data
        $page = (object) [
            'title' => 'Daftar Warga yang terdaftar dalam sistem'
        ];

        // Set the active menu
        $activeMenu = 'warga';
        $activeSubMenu = 'warga_list';

        // Fetch warga data
        $warga = WargaModel::all();
        $alamat = RTModel::all();
        // Return the view with data
        return view('rt.warga.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu,
            'warga' => $warga,
            'alamat' => $alamat
        ]);
    }
// Ambil data level dalam bentuk json untuk datatables
public function list(Request $request)
{
    $user = Auth::user();
    $rt = WargaModel::where('nik', $user->username)->first();
    // Select specific columns from the DataWargaModel
    $dataWarga = WargaModel::select('nik', 'nomor_kk', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'golongan_darah', 'alamat', 'rt', 'rw', 'kelurahan_desa', 'kecamatan', 'kabupaten_kota', 'provinsi', 'agama', 'pekerjaan','status_kependudukan')
                            ->where('rt', $rt->rt);
    
    if ($request->rt){
        $dataWarga->where('rt', $request->rt);
    }
    // Return data in DataTables format
    return DataTables::of($dataWarga)
        ->addIndexColumn() // Add index column (DT_RowIndex)
        ->addColumn('aksi', function ($warga) { // Add action column
            $btn = '<a href="' . url('rt/warga/' . $warga->nik) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('rt/warga/' . $warga->nik . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // Render HTML in the 'aksi' column
        ->make(true);
}
public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Warga Baru'
        ];

        $activeMenu = 'warga'; //set menu yang aktif
        $activeSubMenu = 'warga_list';
        $user = Auth::user();

        $rt = WargaModel::where('nik', $user->username)->first();
     
        $alamatrt = RTModel::where('rt_id', $rt->rt)->first();
        return view('rt.warga.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'alamatrt' => $alamatrt,'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu,]);
    }
    // Menyimpan data warga baru
    public function store(Request $request)
{
    $request->validate([
        'nik' => 'required|string|min:3|max:16|unique:warga,nik',
        'nomor_kk' => 'nullable|string|max:100|exists:keluarga,nomor_kk',
        'nama' => 'required|string|max:255',
        'tempat_lahir' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
        'golongan_darah' => 'nullable|string|max:2',
        'alamat' => 'required|string|max:255',
        'rt' => 'required|string|max:3',
        'rw' => 'required|string|max:3',
        'kelurahan_desa' => 'nullable|string|max:255',
        'kecamatan' => 'nullable|string|max:255',
        'kabupaten_kota' => 'nullable|string|max:255',
        'provinsi' => 'nullable|string|max:255',
        'agama' => 'nullable|string|max:50',
        'pekerjaan' => 'nullable|string|max:100',
        'status_kependudukan' => 'required|string|in:warga,meninggal,pindah,pendatang',
    ], [
        'nomor_kk.exists' => 'Nomor KK belum terdaftar, ubah atau kosongkan form nomor kk.',
    ]);

    WargaModel::create([
        'nik' => $request->nik,
        'nomor_kk' => $request->nomor_kk,
        'nama' => $request->nama,
        // 'tempat_lahir' => $request->tempat_lahir,
        // 'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        // 'golongan_darah' => $request->golongan_darah,
        'alamat' => $request->alamat,
        'rt' => $request->rt,
        'rw' => $request->rw,
        'kelurahan_desa' => $request->kelurahan_desa,
        'kecamatan' => $request->kecamatan,
        'kabupaten_kota' => $request->kabupaten_kota,
        'provinsi' => $request->provinsi,
        // 'agama' => $request->agama,
        // 'pekerjaan' => $request->pekerjaan,
        'status_kependudukan' => $request->status_kependudukan
    ]);

    UserModel::create([
        'level_id' => 3,
        'username' => $request->nik,
        'password' => Hash::make($request->nik),
    ]);

    return redirect('rt/warga')->with('success', 'Data warga baru berhasil ditambahkan');
}
// Menampilkan detail warga
public function show($id)
{
    // Temukan data warga berdasarkan ID
    $warga = WargaModel::find($id);

    // Jika data warga ditemukan, lanjutkan untuk menampilkan halaman detail
    $breadcrumb = (object) [
        'title' => 'Detail Warga',
        'list' => ['Home', 'Warga', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Warga'
    ];

    $activeMenu = 'warga'; // Set menu yang aktif
    $activeSubMenu = 'warga_list';

    return view('rt.warga.show', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'warga' => $warga,
        'activeSubMenu' => $activeSubMenu,
        'activeMenu' => $activeMenu
    ]);
}
public function edit($id)
{
    // Temukan data warga berdasarkan ID
    $warga = WargaModel::find($id);
    $users = UserModel::where('username', $warga->nik)->first();
    // Jika data warga ditemukan, lanjutkan untuk menampilkan halaman detail
    $breadcrumb = (object) [
        'title' => 'Detail Warga',
        'list' => ['Home', 'Warga', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Warga'
    ];

    $activeMenu = 'warga'; // Set menu yang aktif
    $activeSubMenu = 'warga_list';
    $user = Auth::user();

    $rt = WargaModel::where('nik', $user->username)->first();
 
    $alamatrt = RTModel::where('rt_id', $rt->rt)->first();
    return view('rt.warga.edit', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'warga' => $warga,
        'user' => $users,
        'alamatrt' => $alamatrt,
        'activeSubMenu' => $activeSubMenu,
        'activeMenu' => $activeMenu
    ]);
}
public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|min:3',
            'nomor_kk' => 'required|string|max:100|exists:keluarga,nomor_kk',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|string|max:2',
            'alamat' => 'required|string|max:255',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kelurahan_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'status_kependudukan' => 'required|string|in:warga,meninggal,pindah,pendatang',
        ],[
            'nomor_kk.exists' => 'Nomor KK belum terdaftar'
        ]);

        WargaModel::find($id)->update([
            'nik' => $request->nik,
            'nomor_kk' => $request->nomor_kk,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'golongan_darah' => $request->golongan_darah,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan_desa' => $request->kelurahan_desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'status_kependudukan' => $request->status_kependudukan
        ]);

        return redirect('rt/warga')->with('success', 'Data warga berhasil diubah');
    }


}
