<?php

namespace App\Http\Controllers;

use App\BackupManager;
use App\Project;
use App\Task;
use App\Exceptions\NoResultException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user_id = request()->user()->id;
            $projects = Project::where([
                'user_id' => $user_id
            ])->get();
            foreach ($projects as $key => $project) {
                $projects[$key]['tasks'] = Task::where([
                    'user_id' => $user_id,
                    'project_id' => $project->id
                ])->get();
            }
            return view('projects.index', [
                'title' => 'Projects',
                'subtitle' => "little or big objectives you want to achieve",
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your projects.');
        }
        
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
        try {
            $user_id = request()->user()->id;
            $data = request()->all();

            $project = new Project();
            $project->name = $data['name'];
            $project->description = $data['description'];
            $project->user_id = $user_id;

            $project->save();
            BackupManager::dumpDatabase('myregister');
            return redirect()->route('projects.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while storing your project.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     try {
    //         $user_id = request()->user()->id;
    //         $project = Project::where([
    //             'id' => $id,
    //             'user_id' => $user_id
    //         ])->first();
    //         return view('projects.show',[
    //             'title' => 'Projects',
    //             'subtitle' => "little or big objectives you want to achieve",
    //             'project' => $project
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return redirect()->back()->with('error','There was an error while getting your project.');
    //     }
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user_id = request()->user()->id;
            $project = Project::where([
                'user_id' => $user_id,
                'id' => $id
            ])->first();
            if($project == null) {
                throw new NoResultException("Project Not Found", 1);
            }
            return view('projects.edit', [
                'project' => $project
            ]);
        } catch (NoResultException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your project.');
        }
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
        try {
            $user_id = request()->user()->id;
            $data = request()->all();
            $project = Project::where([
                'id' => $id,
                'user_id' => $user_id
            ])->first();
            if($project == null) {
                throw new NoResultException("Project Not Found", 1);
            }
            $project->name = $data['name'];
            $project->description = $data['description'];
            $project->save();
            BackupManager::dumpDatabase('myregister');
            return redirect()->route('projects.index');
        } catch (NoResultException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while updating your project.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $project = Project::where([
                'user_id' => request()->user()->id,
                'id' => $id
            ])->first();
            if($project == null) {
                throw new NoResultException("Project Not Found", 1);
            }
            DB::table('tasks')->where('project_id', '=', $project->id)->delete();
            Project::destroy($project->id);
            return redirect()->route('projects.index');
        } catch (NoResultException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while deleting your project.');
        }
    }

    public function completeProject($id)
    {
        try {
            $user_id = request()->user()->id;
            $project = Project::where([
                'id' => $id,
                'user_id' => $user_id
            ])->first();
            if($project == null) {
                throw new NoResultException("Project Not Found", 1);
            }
            $project->completed = true;
            $project->save();
            return redirect()->back();
        } catch (NoResultException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while setting your project as completed.');
        }
    }
}
