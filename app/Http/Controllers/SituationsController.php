<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Situation;
use App\BackupManager;

class SituationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = request()->user()->id;
        $situations = Situation::where('user_id',$user_id)->get();
        return view('situations.index', [
            'situations' => $situations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('situations.create', [
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
        $user_id = request()->user()->id;
        $data = $request->all();
        $situation = new Situation();
        $situation->situation = $data['situation'];
        $situation->user_id = $user_id;
        $situation->save();

        BackupManager::dumpDatabase('myregister');
        return redirect()->route('situations.index');
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
        //
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
        //
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
        $situation = Situation::where('user_id', $user_id)->where('id',$id)->first();
        Situation::destroy($situation->id);

        BackupManager::dumpDatabase('myregister');
        return redirect()->route('situations.index');
    }
}
