<?php

namespace App\Http\Controllers;

use App\InvitationToken;
use Illuminate\Http\Request;

class InvitationTokenController extends Controller
{
    public function index()
    {
        $user_id = request()->user()->id;
        $invitations = InvitationToken::where([
            'user_id' => $user_id
        ])->get();
        return view('invitations.index',[
            'title' => 'Invitations',
            'subtitle' => 'Invitations',
            'invitations' => $invitations
        ]);
    }

    public function create()
    {
        return view('invitations.create',[
            'title' => 'New Invitation'
        ]);
    }

    public function store()
    {
        $data = request()->all();
        $user_id = request()->user()->id;
        if(!isset($data['invitationToken']) || $data['invitationToken'] == ""){
            $random_bytes = rand(0,1000000);
            $data['invitationToken'] = $random_bytes;
        }
        $invToken = new InvitationToken();
        $invToken->user_id = $user_id;
        $invToken->invitation_token = $data['invitationToken'];
        try {
            $invToken->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return redirect()->route('invitations.index');
    }
}
