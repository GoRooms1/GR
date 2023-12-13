<?php

namespace App\Console\Commands\Costs;

use Carbon\Carbon;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostPeriod;
use Domain\Settings\Models\Settings;
use Illuminate\Console\Command;

class CalculateAvg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'costs:calculate-avg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate avg value for costs';

    /**
     * Execute the console command. 
     * @return int
     */
    public function handle(): int
    {
        $avg_period = intval(Settings::option('avg_cost_period', "0"));
        $costs = Cost::all();
        $this->output->progressStart($costs->count());

        foreach ($costs as $cost) {
           $cost->avg_value = $cost->value > 0 ? $this->getAvgValue($cost, $avg_period) : 0;
           $cost->save();
           $this->output->progressAdvance();
        }

        $costPeriods = CostPeriod::where('date_to', '<', Carbon::now()->startOfDay()->subDays($avg_period))
                ->where('is_active', false)
                ->get();

        foreach ($costPeriods as $costPeriod) {
            $costPeriod->delete();
        }

        $this->output->progressFinish();
        \Cache::flush();
        return 0;
    }

    private function getAvgValue(Cost $cost, int $avg_period)
    {
        $cost_value = $cost->value ?? 0;
        $date = Carbon::now()->startOfDay();
        $sum_value = 0;       

        if ($avg_period <= 0)
            return $cost_value;

        for ($i = 1; $i <= $avg_period; $i++) {
            $value = CostPeriod::where('cost_id', $cost->id)
                ->where('date_from', '<=', $date)
                ->where('date_to', '>=', $date)
                ->where('value','>', 0)
                ->min('value');

            $value = $value > 0 ? $value : $cost_value;
            $sum_value += $value;
            $date = $date->subDay();
        }

        return floor($sum_value / $avg_period);
    }
}
