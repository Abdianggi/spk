<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();

        // $this->middleware('auth');

        // $this->middleware('permission:user.show')->only('index', 'show', 'data');
        // $this->middleware('permission:user.create')->only('create', 'store');
        // $this->middleware('permission:user.edit')->only('edit', 'update');
        // $this->middleware('permission:user.delete')->only('destroy');
    }

    public function datatable(Request $request) : JsonResponse
    {
        if ($request->ajax()) {
            $data = User::latest();

            return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $html = "";
                
                            // if($this->auth->can('category.show'))
                            //     $html .= "<a href='" . route('superadmin.category.show', $row->id) . "' class='btn btn-info btn-sm me-1 mb-1'><i class='fas fa-eye me-1'></i> Show</a>";
                
                            // if($this->auth->can('category.edit'))
                                // $html .= "<a href='" . route('superadmin.category.edit', $row->id) . "' class='btn btn-warning btn-sm me-1 mb-1'><i class='fas fa-edit me-1'></i> Edit</a>";
                                $html .= "<button class='btn btn-warning btn-sm btn-edit mb-1 me-1' data-id='" . $row->id . "' data-bs-toggle='modal' data-bs-target='#modal-success'><i class='fas fa-edit me-1'></i> Edit</button>";
                
                            // if($this->auth->can('category.delete'))
                                $html .= "<button class='btn btn-danger btn-sm btn-delete mb-1 me-1' data-id='" . $row->id . "'><i class='fas fa-trash me-1'></i> Delete</button>";
                            
                
                            return $html;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
        }
        return abort(404);
    }

    public function index()
    {
        return view('pages.user.index',[
            'title' => 'Users Data'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
