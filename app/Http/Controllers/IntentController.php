<?php

namespace App\Http\Controllers;

use App\Models\Intent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class IntentController extends Controller
{
    const SUPPORTED_ORDERS = [
        self::ORDER_ANSWERS_COUNT,
        self::ORDER_STATUS,
        self::ORDER_TITLE,
        self::ORDER_CREATED_AT,
        self::ORDER_UPDATED_AT,
    ];

    const ORDER_ANSWERS_COUNT = 'answers_count';
    const ORDER_STATUS = 'status';
    const ORDER_TITLE = 'title';
    const ORDER_CREATED_AT = 'created_at';
    const ORDER_UPDATED_AT = 'updated_at';

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $intentCollection = $this->buildQuery($request);
        } catch (\InvalidArgumentException $e) {
            return response()->json('Invalid order by supplied', 400);
        }

        return response()->json($intentCollection);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    private function buildQuery(Request $request): Collection
    {
        $queryBuilder = Intent::query();
        $queryBuilder->withCount('answers');

        foreach ($request->get('orderBy', ['title']) as $order) {
            if (in_array($order, self::SUPPORTED_ORDERS)) {
                // If we ever need more special orders
                switch ($order) {
                    case 'answers_count':
                        $queryBuilder->orderBy('answers_count', 'desc');
                        break;
                    default:
                        $queryBuilder->orderBy($order);
                }
            } else {
                throw new InvalidArgumentException();
            }
        }

        return $queryBuilder->limit(4)->get();
    }

    /**
     * @param Request $request
     * @return View
     */
    public function view(Request $request): View
    {
        try {
            $intentCollection = $this->buildQuery($request);
        } catch (\InvalidArgumentException $e) {
            return view('intents', ['error' => 'Invalid order by supplied']);
        }

        return view('intents', ['intents' => $intentCollection]);
    }
}
