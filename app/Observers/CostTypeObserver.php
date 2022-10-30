<?php

namespace App\Observers;

use Domain\Room\Models\CostType;
use Illuminate\Support\Str;

class CostTypeObserver
{
    /**
     * Handle the CostType "created" event.
     *
     * @param  \Domain\Room\Models\CostType  $costType
     * @return void
     */
    public function created(CostType $costType): void
    {
        $slug = Str::slug($costType->name);
        if (! CostType::where('slug', $slug)->exists()) {
            $costType->slug = $slug;
        } else {
            $costType->slug = $slug.'-'.$costType->id;
        }
        $costType->save();
    }

    /**
     * Handle the CostType "updated" event.
     *
     * @param  CostType  $costType
     * @return void
     */
    public function updated(CostType $costType): void
    {
        //
    }

    /**
     * Handle the CostType "deleted" event.
     *
     * @param  CostType  $costType
     * @return void
     */
    public function deleted(CostType $costType): void
    {
        //
    }

    /**
     * Handle the CostType "restored" event.
     *
     * @param  \Domain\Room\Models\CostType  $costType
     * @return void
     */
    public function restored(CostType $costType): void
    {
        //
    }

    /**
     * Handle the CostType "force deleted" event.
     *
     * @param  \Domain\Room\Models\CostType  $costType
     * @return void
     */
    public function forceDeleted(CostType $costType): void
    {
        //
    }
}
