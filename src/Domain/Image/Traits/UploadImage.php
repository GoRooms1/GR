<?php

declare(strict_types=1);

namespace Domain\Image\Traits;

use App\Helpers\Json;
use App\Parents\Model;
use Carbon\Carbon;
use Domain\AdBanner\Models\AdBanner;
use Domain\Hotel\Models\Hotel;
use Domain\Image\Actions\UploadImageAction;
use Domain\Room\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\Enums\ModelNamesEnum;

trait UploadImage
{
    public function upload(Request $request): ?JsonResponse
    {
        $path = false;
        if ($files = $request->allFiles()) {
            foreach ($files as $file) {
                $path = '/storage/'.$file->store(date('Y/m/d'));
            }
        }
        if ($path) {
            return response()->json(['location' => $path]);
        }

        return abort(500);
    }

    /**
     * Delete Image
     *
     * @param  Media  $image
     * @return JsonResponse
     */
    public function delete(Media $image): JsonResponse
    {
        try {
            if ($this->checkLastImage($image)) {
                return Json::answer(['error' => 'Нельзя удалить последнюю фотографию'], false, 200);
            }

            $image->delete();

            return Json::good(['deleted' => true]);
        } catch (\Exception $exception) {
            return Json::bad(['error' => $exception->getMessage()]);
        }
    }

    public function uploadFor(Request $request): JsonResponse
    {
        /** @var string $modelShort */
        $modelShort = $request->get('model_name');
        $modelID = $request->get('modelID');

        try {
            /** @var class-string<Model> $modelName */
            $modelName = '\\App\\Models\\'.$modelShort;

            if (! class_exists($modelName)) {
                $modelEnum = ModelNamesEnum::fromName($modelShort);
                /** @var class-string<Model> $modelName */
              
                $modelName = $modelEnum->getClassName();
            }

            $model = $modelName::findOrFail($modelID);

            if ($model->updated_at) {
                $model->updated_at = Carbon::now();
                $model->save();
            }

            if ($this->checkLimit($model)) {                
                return Json::answer(['error' => 'Нельзя добавить больше!'], false, 200);
            }
            
            $images = UploadImageAction::run($request, $model);

            return Json::good(['images' => $images]);
        } catch (\Exception $exception) {
            return Json::bad(['error' => $exception->getMessage()]);
        }
    }

    private function checkLastImage(Media $image): bool
    {
        /** @var class-string<Model> $model */
        $model = $image->model_type;

        if ($model == Hotel::class || $model == Room::class) {
            $object = $model::find($image->model_id);
            return $object->getMedia('images')->count() === 1;
        }

        return false;
    }

    private function checkLimit($model): bool
    {
        if (get_class($model) != AdBanner::class)
            return false;

        return $model->getMedia('images')->count() >= 3;
    }
}
