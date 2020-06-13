<?php

namespace App\Http\Controllers;

use App\Situation;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BackupManager;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($situation = null)
    {
        $user_id = request()->user()->id;
        $tasks = Task::where('user_id',$user_id)->whereNull('situation_id')->get();
        return view('task.index', [
            'title' => 'Inbox',
            'subtitle' => "put your stuff here",
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = request()->user()->id;
        $situations = Situation::where('user_id', $user_id)->get();
        return view('task.create', [
            'situations' => $situations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * 1 - mapeamento situation numero string
         * 2 - segurança do form
         * 4 - mostrar usuario eloquent
         * @todo validate these inputs
         */
        $data = $request->all();
        $task = new Task();
        $task->name = $data['name'];
        // $task->description = $data['description'];
        $task->user_id = $request->user()->id;
        $task->save();

        BackupManager::dumpDatabase('myregister');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = request()->user()->id;
        $task = Task::where('user_id', $user_id)->where('id',$id)->first();
        return view('task.show', [
            'task' => $task
        ]);
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
        $task = Task::where('user_id', $user_id)->where('id',$id)->first();
        $situations = Situation::where('user_id', $user_id)->get();
        return view('task.edit', [
            'task' => $task,
            'situations' => $situations
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
        /**
         * @todo validate these inputs
         */
        $user_id = request()->user()->id;
        $data = $request->all();
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

        if(isset($data['targetSituation'])) {
            $task->situation_id = $data['targetSituation'];
        }
        if(isset($data['duedate'])) {
            $task->duedate = $data['duedate'];
        }
        $task->name = $data['name'];
        $task->description = $data['description'];
        $teste = $task->save();
        
        BackupManager::dumpDatabase('myregister');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = request()->user()->id;
        $task = Task::where('user_id', $user_id)->where('id',$id)->first();
        Task::destroy($task->id);

        BackupManager::dumpDatabase('myregister');
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tickler()
    {
        $user_id = request()->user()->id;
        $tasks = Task::where([
            'user_id' => $user_id,
            'situation_id' => 1
        ])->get();

        // foreach ($tasks as $key => $task) {
        //     $data = $task->duedate;
        //     $dateObject = \DateTime::createFromFormat('Y-m-d H:i:s',$data);
        //     $tasks[$key]->duedateObj = $dateObject;
        //     $tasks[$key]->duedateReadable = $dateObject->format('D, d M Y H:i:s');
        // }
        return view('task.index', [
            'title' => 'Tickler',
            'subtitle' => "stuff you need to remember today",
            'tasks' => $tasks
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function waitingfor($situation = null)
    {
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recurring($situation = null)
    {
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function next($situation = null)
    {
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function readlist($situation = null)
    {
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function somedaymaybe($situation = null)
    {
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
    }
}
