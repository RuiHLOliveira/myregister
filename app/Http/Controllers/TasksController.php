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
        $tasks = Task::where('user_id',$user_id)->get();
        return view('task.index', [
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
        $task->description = $data['description'];
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

        if(isset($data['situationInput'])){
            $situation = new Situation();
            $situation->situation = $data['situationInput'];
            $situation->user_id = $user_id;
            $situation->save();
            $task->situation_id = $situation->id;
        } elseif(isset($data['situationSelect'])) {
            $task->situation_id = $data['situationSelect'];
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
        return redirect()->route('tasks.index');
    }
}
