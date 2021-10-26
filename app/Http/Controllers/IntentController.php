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

    const ORDER_DIRECTIONS = [
        self::ORDER_ANSWERS_COUNT => 'desc'
    ];

    const ORDER_ANSWERS_COUNT = 'answers_count';
    const ORDER_STATUS = 'status';
    const ORDER_TITLE = 'title';
    const ORDER_CREATED_AT = 'created_at';
    const ORDER_UPDATED_AT = 'updated_at';

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * Used for API
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $intentCollection = $this->buildQuery($request);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json($intentCollection);
    }

    /**
     * @param Request $request
     * @return View
     *
     * Used for web
     */
    public function view(Request $request): View
    {
        try {
            $intentCollection = $this->buildQuery($request);
        } catch (\InvalidArgumentException $e) {
            return view('intents', ['error' => $e->getMessage()]);
        }

        return view('intents', ['intents' => $intentCollection]);
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
                $queryBuilder->orderBy($order, self::getOrderDirection($order));
            } else {
                throw new InvalidArgumentException("Invalid order by supplied");
            }
        }

        return $queryBuilder->limit(4)->get();
    }

    /**
     * @param string $order
     * @return string
     */
    private static function getOrderDirection(string $order): string
    {
        return self::ORDER_DIRECTIONS[$order] ?? self::DEFAULT_ORDER_DIRECTION;
    }
}
