<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function situation()
    {
        return $this->belongsTo('App\Situation');
    }

    public function project() {
        return $this->belongsTo('App\Project', 'project_id');
    }


    public function getReadableDate(){
        if(is_null($this->duedate)) return null;
        $date = $this->duedate;
        $dateObject = \DateTime::createFromFormat('Y-m-d H:i:s',$date);
        $duedateReadable = $dateObject->format('D, d M Y');// H:i:s
        return $duedateReadable;
    }

    public function getDate(){
        if(is_null($this->duedate)) return null;
        $date = $this->duedate;
        $dateObject = \DateTime::createFromFormat('Y-m-d H:i:s',$date);
        $date = $dateObject->format('Y-m-d');
        return $date;
    }
    
}
