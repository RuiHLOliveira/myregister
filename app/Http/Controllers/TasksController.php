<?php

namespace App\Http\Controllers;

use App\Situation;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\BackupManager;
use App\Project;

class TasksController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $user_id = request()->user()->id;
            $situations = Situation::where('user_id', $user_id)->get();
            return view('task.create', [
                'situations' => $situations
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error.');
        }
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
            //code...
            $data = $request->all();
            if(!isset($data['name']) || $data['name'] == ''){
                return redirect()->back()->withError('Name is needed');
            }
            $task = new Task();
            $task->name = $data['name'];
            $task->user_id = $request->user()->id;

            if (isset($data['project']) ) {
                $project = Project::where([
                    'user_id' => $task->user_id,
                    'id' => $data['project']
                ])->first();
                $task->project_id = $project->id;
            }
            $task->save();

            BackupManager::dumpDatabase('myregister');
            return redirect()->route('tasks.index');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'There was an error while storing your task.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user_id = request()->user()->id;
            $task = Task::where('user_id', $user_id)->where('id',$id)->first();
            return view('task.show', [
                'title' => 'Details',
                'subtitle' => "about your item",
                'task' => $task
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error in your task.');
        }
    }

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
            $task = Task::where('user_id', $user_id)->where('id',$id)->first();
            if($task == null){
                return redirect()->route('tasks.index');
            }
            $situations = Situation::where('user_id', $user_id)->get();

            $projects = Project::where([
                'user_id' => $user_id
            ])->get();
            
            return view('task.edit', [
                'task' => $task,
                'situations' => $situations,
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'There was an error in your task.');
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
            $data = $request->all();
            if(!isset($data['name']) || $data['name'] == ''){
                return redirect()->back()->withError('Name is needed');
            }
            
            $user_id = request()->user()->id;
            $task = Task::where('user_id', $user_id)->where('id', $id)->first();

            // if(isset($data['situationInput'])){
            //     $situation = new Situation();
            //     $situation->situation = $data['situationInput'];
            //     $situation->user_id = $user_id;
            //     $situation->save();
            //     $task->situation_id = $situation->id;
            // } elseif(isset($data['situationSelect'])) {
            //     $task->situation_id = $data['situationSelect'];
            // }

            if(isset($data['considerProjectForm']) 
                && $data['considerProjectForm'] == 1
                && isset($data['project'])
                && $data['project'] != ''
            ) {
                $project = Project::where([
                    'user_id' => $user_id,
                    'id' => $data['project']
                ])->first();
                $task->project_id = $project->id;
            }

            if(isset($data['targetSituation'])) {
                $task->situation_id = $data['targetSituation'];
            }
            if(isset($data['duedate'])) {
                $task->duedate = $data['duedate'];
            }
            $task->name = $data['name'];
            $task->description = $data['description'];
            
            $saveResult = $task->save();
            
            BackupManager::dumpDatabase('myregister');
            return redirect()->route('tasks.index');

        } catch (\Exception $e) {
            Log::error($e->getMessage());            
            return redirect()->back()->with('error','There was an error while updating your task.');
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
            $user_id = request()->user()->id;
            $task = Task::where('user_id', $user_id)->where('id',$id)->first();
            Task::destroy($task->id);
            BackupManager::dumpDatabase('myregister');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while deleting your task.');
        }
    }


    /**
     * Lists all Inbox (situation == null) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where('user_id',$user_id)->whereNull('situation_id')->get();
            return view('task.index', [
                'title' => 'Inbox',
                'subtitle' => "put your stuff here",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Tickler (situation == 1) tasks
     * 
     * @return \Illuminate\Http\Response
     */
    public function tickler()
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 1
            ])->get();

            return view('task.index', [
                'title' => 'Tickler',
                'subtitle' => "stuff you need to remember today",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Waiting For (situation == 2) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function waitingfor($situation = null)
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 2
            ])->orderBy('duedate','asc')->get();
            return view('task.index', [
                'title' => 'Waiting For',
                'subtitle' => "waiting someone's callback",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Recurring (situation == 3) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function recurring($situation = null)
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 3
            ])->get();
            return view('task.index', [
                'title' => 'Recurring',
                'subtitle' => "tasks you do everyday",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Next (situation == 4) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function next($situation = null)
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 4
            ])->get();
            return view('task.index', [
                'title' => 'Next',
                'subtitle' => "next actions you need to do",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Reading List (situation == 5) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function readlist($situation = null)
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 5
            ])->get();
            return view('task.index', [
                'title' => 'Reading List',
                'subtitle' => "articles, videos and stuff you want to read/watch",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }

    /**
     * Lists all Someday/maybe (situation == 6) tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function somedaymaybe($situation = null)
    {
        try {
            $user_id = request()->user()->id;
            $tasks = Task::where([
                'user_id' => $user_id,
                'situation_id' => 6
            ])->get();
            return view('task.index', [
                'title' => 'Someday/Maybe',
                'subtitle' => "things you want to do someday, but not week... or this month... or this year",
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while getting your tasks.');
        }
    }
    
    public function taskToProject($id){
        try {
            $user_id = request()->user()->id;
            $task = Task::where([
                'id' => $id,
                'user_id' => $user_id
            ])->first();
            if($task == null){
                return redirect()->back();
            }
            $project = new Project();
            $project->name = $task->name;
            $project->description = $task->description;
            $project->duedate = $task->duedate;
            $project->user_id = $user_id;
            $project->save();
            $task->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while converting this task to project.');
        }
    }

    public function completeTask($id) {
        try {
            $user_id = request()->user()->id;
            $task = Task::where([
                'id' => $id,
                'user_id' => $user_id
            ])->first();
            if($task == null){
                return redirect()->back()->with('error','This task doesnt exist.');
            }
            $task->completed = true;
            $task->save();
            return redirect()->route('tasks.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error','There was an error while trying to complete this task.');
        }
    }
}
