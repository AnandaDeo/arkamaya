<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Carbon\Carbon;
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
        $project = Project::get();
        return view('contents.project', compact('client','project'));
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

    public function datatable(Request $request){
        $data = Project::query()->with('client');
        return datatables()->eloquent($data)
            ->editColumn('project_start_date', function($model){
                return $model->project_start_date->translatedFormat('d M Y');
            })
            ->editColumn('project_end_date', function($model){
                $date = Carbon::parse($model->project_end_date);
                return $model->project_end_date->translatedFormat('d M Y');
            })
            ->filter(function ($instance) use ($request) {

                if ($request->get('project_name')) {

                    $instance->where('project_name', 'LIKE', '%' . $request->project_name . '%');
                }

                if ($request->get('client_id')) {

                    $instance->where('client_id', $request->client_id);
                }

                if ($request->get('status')) {

                    $instance->where('project_status', $request->status);
                }
            })
            ->make();
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
