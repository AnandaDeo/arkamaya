<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::get();
        return view('contents.project', compact('client'));
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
        $request->validate([
            'project_name' => 'required',
            'client_id' => 'required',
        ]);

        Project::create([
            'project_name' => $request->project_name,
            'client_id' => $request->client_id,
            'project_start_date' => $request->project_start_date,
            'project_end_date' => $request->project_end_date,
            'project_status' => $request->project_status
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Success Add Project!',
        ]);
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
    public function edit($id)
    {
        return response()->json([
            'data'  => Project::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'project_name' => 'required',
            'client_id' => 'required',
        ]);

        Project::find($id)->update([
            'project_name' => $request->project_name,
            'client_id' => $request->client_id,
            'project_start_date' => $request->project_start_date,
            'project_end_date' => $request->project_end_date,
            'project_status' => $request->project_status
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Success Update Project!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function datatable(){
        $data = Project::with('client')->get();
        return DataTables::of($data)->make();
    }

    public function deleteSelected(Request $request){
        $ids = $request->checkedItem;
        Project::whereIn('id', $ids)->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Success Delete Selected Items!',
        ]);
    }
}