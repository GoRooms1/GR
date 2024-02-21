<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use Domain\Review\DataTransferObjects\ReviewCardData;
use Domain\Review\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function getReviews(Request $request): JsonResponse
    {       
        if ($request->get('room_id', false)) {
            $reviews = Review::where('room_id', $request->get('room_id'))->get();

            return Json::good(['reviews' => ReviewCardData::collection($reviews)]);
        }

        if ($request->get('hotel_id', false)) {
            $reviews = Review::where('hotel_id', $request->get('hotel_id'))->get();

            return Json::good(['reviews' => ReviewCardData::collection($reviews)]);
        }

        return Json::good(['reviews' => []]);
    }
}
