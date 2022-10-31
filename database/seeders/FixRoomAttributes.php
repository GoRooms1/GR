<?php

namespace Database\Seeders;

use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Room;
use Illuminate\Database\Seeder;

class FixRoomAttributes extends Seeder
{
    public function run(): void
    {
        $rooms = Room::withoutGlobalScopes()->get();

        foreach ($rooms as $room) {
            $attrs = $room->attrs;

            foreach ($attrs as $attr) {
                if ($attr->model = Hotel::class) {
                    $aNewFlag = Attribute::where('name', $attr->name)->where('model', Room::class)->exists();
                    if ($aNewFlag) {
                        $id = Attribute::where('name', $attr->name)->where('model', Room::class)->first()->id;
                    } else {
                        $aNew = new Attribute([
                            'model' => Room::class,
                            'name' => $attr->name,
                            'in_filter' => $attr->in_filter,
                            'attribute_category_id' => $attr->attribute_category_id,
                        ]);
                        $aNew->save();

                        $id = $aNew;
                    }

                    $room->attrs()->detach($attr->id);
                    $room->attrs()->attach($id);
                }
            }
        }
    }
}
