<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('backup {database}', function(){
    $database = $this->argument('database');
    $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $date = $date->format('Y-m-d---H-i-s');
    $this->info($date);
    $path = base_path()."/dump_".$database."_".$date.".sql";
    $this->info($path);
    return shell_exec("mysqldump --user=root --password=rooting --lock-tables --databases $database > $path");
});

Artisan::command('describe {table}',function(){
    $table = $this->argument('table');
    if (! \Illuminate\Support\Facades\Schema::hasTable($table)) {
        return $this->warn('Sorry, table not found.');
    }
    $columns = \Illuminate\Support\Facades\DB::select("DESC {$table}");
    $headers = [
        'Field', 'Type', 'Null', 'Key', 'Default', 'Extra',
    ];
    $rows = collect($columns)->map(function ($column) {
        return get_object_vars($column);
    });
    return $this->table($headers, $rows);
});