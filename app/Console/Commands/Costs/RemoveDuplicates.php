<?php

namespace App\Console\Commands\Costs;

use DB;
use Illuminate\Console\Command;

class RemoveDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'costs:remove-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove costs duplicates';

    /**
     * Execute the console command. 
     * @return int
     */
    public function handle(): int
    {
        $delteQuery = "DELETE c2 ";
        $delteQuery .= "FROM costs c1 ";
        $delteQuery .= "INNER JOIN costs c2 ";
        $delteQuery .= "WHERE ";
        $delteQuery .= "c1.room_id = c2.room_id ";
        $delteQuery .= "AND c1.period_id = c2.period_id ";
        $delteQuery .= "AND c1.id < c2.id";  

        $d = DB::delete($delteQuery);

        return $d;
    }
}
