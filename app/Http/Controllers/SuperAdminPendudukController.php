<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class SuperadminPendudukController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function datatable(Request $request) : JsonResponse
    {
        if ($request->ajax()) {
            $data = Penduduk::latest();

            return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $html = "";
                
                            // if($this->auth->can('category.show'))
                            //     $html .= "<a href='" . route('superadmin.category.show', $row->id) . "' class='btn btn-info btn-sm me-1 mb-1'><i class='fas fa-eye me-1'></i> Show</a>";
                
                            // if($this->auth->can('category.edit'))
                                // $html .= "<a href='" . route('superadmin.category.edit', $row->id) . "' class='btn btn-warning btn-sm me-1 mb-1'><i class='fas fa-edit me-1'></i> Edit</a>";
                                $html .= "<button class='btn btn-warning btn-sm btn-edit mb-1 me-1' data-id='" . $row->id . "' data-bs-toggle='modal' data-bs-target='#modal-success'><i class='bi bi-pencil'></i></button>";
                
                            // if($this->auth->can('category.delete'))
                                $html .= "<button class='btn btn-danger btn-sm btn-delete mb-1 me-1' data-id='" . $row->id . "'><i class='bi bi-trash'></i></button>";
                            
                
                            return $html;
                        })
                        ->editColumn('created_at', function($row){
                            return \Carbon\Carbon::parse($row->created_at)->translatedFormat('l, d F Y - H:m:s');
                        })
                        ->rawColumns(['action'])
                        ->make(true);
        }
        return abort(404);
    }

    public function index()
    {
        return view('pages.penduduk.index',[
            'title' => 'Data Penduduk'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $response = array();

        DB::beginTransaction();
        try {

            $this->validate($request, [
                'penduduk_nokk'         => 'required',
                'penduduk_namakepala'   => 'required',
            ]);

            
            foreach ($request->penduduk_nokk as $k => $v) {
                $penduduk                         = new Penduduk();
                $penduduk->no_kk                  = $v;
                $penduduk->nama_kepala_keluarga   = $request->penduduk_namakepala[$k];
                $penduduk->alamat                 = $request->penduduk_alamat[$k];
               
                $penduduk->save();
            }

            $response['message']    = 'Penduduk ditambahkan!';
            $response['type']       = 'success';
            $response['status']     = true;
            

        } catch (Exception $e) {
            DB::rollBack();
            
            $response['message']    = $e->getMessage();
            $response['type']       = 'error';
            $response['status']     = false;
            return response()->json($response);  
        }
        DB::commit();

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function pendudukDestroy($id){
        DB::beginTransaction();
        try{

            $penduduk        = Penduduk::findOrFail($id);
            // $penduduk->deleted_by   = auth()->user()->id;
            // $penduduk->save();

            $penduduk->delete();
            
        }catch(Exception $e){
            DB::rollback();
            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'danger',
                'status'     => false,
            );

            return response()->json($notification);
        }

        DB::commit();

        $notification = array(
            'status' => true,
            'message' => 'Penduduk dihapus!',
        );

        return response()->json($notification);
    }
    public function destroy($id)
    {
        dd($id);
        DB::beginTransaction();
        try{

            $penduduk        = Penduduk::findOrFail($id);
            // $penduduk->deleted_by   = auth()->user()->id;
            // $penduduk->save();

            $penduduk->delete();
            
        }catch(Exception $e){
            DB::rollback();
            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'danger',
                'status'     => false,
            );

            return response()->json($notification);
        }

        DB::commit();

        $notification = array(
            'status' => true,
            'message' => 'Penduduk dihapus!',
        );

        return response()->json($notification);
    }
}
