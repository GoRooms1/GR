<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Metro;
use Illuminate\Console\Command;

class UpdateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $address_fields = ['city',
            'street',
            'city_district',
            'city_area',
            'street_with_type'];
        $addresses = Address::query()
            ->select($address_fields)->get();
        $rows = [];
        foreach ($addresses AS $address) {
            foreach ($address_fields AS $field) {
                $item = [
                    'address' => $address->$field,
                    'slug' => \Str::slug($address->$field)
                ];
                \DB::table('address_slug')->updateOrInsert($item, $item);
            }
        }
        $metros = Metro::all();
        foreach ($metros AS $metro) {
            $item = [
                'address' => $metro->name,
                'slug' => \Str::slug($metro->name)
            ];
            \DB::table('address_slug')->updateOrInsert($item, $item);
        }
    }
}
