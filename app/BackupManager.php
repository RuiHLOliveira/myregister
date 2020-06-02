<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class BackupManager extends Model
{
   public static function dumpDatabase ($database) {
        Artisan::call("backup",[
            'database' => $database
        ]);
   }
}