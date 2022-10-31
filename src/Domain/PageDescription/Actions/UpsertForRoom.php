<?php

declare(strict_types=1);

namespace Domain\PageDescription\Actions;

use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static PageDescriptionData run(PageDescriptionData $data, Room $room)
 */
final class UpsertForRoom extends Action
{
    public function handle(PageDescriptionData $data, Room $room): PageDescriptionData
    {
        if (! $data->title && ! $data->meta_description && ! $data->meta_keywords) {
            return $data;
        }
        $key = $room->getRouteKeyName();
        $url = '/rooms/'.$room->$key;
        $data->url = $url;
        $data->model_id = $room->id;
        $meta = PageDescription::updateOrCreate(['url' => $data->url], $data->toArray());
        $meta->model_type = $data->model_type;
        $meta->save();

        $room->meta()->save($meta);

        $data->id = $meta->id;

        return $data;
    }
}
