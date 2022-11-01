<?php

declare(strict_types=1);

namespace Domain\Image\Traits;

use App\Helpers\Json;
use App\Parents\Model;
use Carbon\Carbon;
use Domain\Image\Actions\UploadImageAction;
use Domain\Image\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param  Image  $image
     * @return JsonResponse
     */
    public function delete(Image $image): JsonResponse
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
            $images = UploadImageAction::run($request, $model);

            return Json::good(['images' => $images]);
        } catch (\Exception $exception) {
            return Json::bad(['error' => $exception->getMessage()]);
        }
    }

    private function checkLastImage(Image $image): bool
    {
        /** @var class-string<Model> $model */
        $model = $image->model_type;
        $object = $model::find($image->model_id);

        return $object->images()->count() === 1;
    }
}
