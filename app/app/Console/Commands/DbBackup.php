<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbBackup extends Command
{

    protected $signature = 'db:backup';

    protected $description = 'Create Database Backup';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = "backup_".strtotime(now()).".sql";
        $command = "pg_dump --host ".env('DB_HOST')." --username ".env('DB_USERNAME')." ".env('DB_DATABASE')." > ".
            storage_path()."/app/backup/".$filename;
        exec($command);
        //echo $command;
    }


}




?>