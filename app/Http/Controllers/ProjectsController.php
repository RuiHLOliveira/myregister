<?php

namespace App\Http\Controllers;

use App\BackupManager;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = request()->user()->id;
        $projects = Project::where('user_id', $user_id)->get();
        return view('project.index',[
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = request()->user()->id;
        $data = request()->all();

        $project = new Project();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->user_id = $user_id;

        $project->save();
        BackupManager::dumpDatabase('myregister');
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = request()->user()->id;
        $project = Project::where([
            'user_id' => $user_id,
            'id' => $id
        ])->first();
        return view('project.edit', [
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = request()->user()->id;
        $data = request()->all();
        $project = Project::where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->save();
        BackupManager::dumpDatabase('myregister');
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::where([
            'user_id' => request()->user()->id,
            'id' => $id
        ])->first();
        Project::destroy($project->id);
        return redirect()->route('projects.index');
    }
}
