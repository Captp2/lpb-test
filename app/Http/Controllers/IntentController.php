<?php

namespace App\Http\Controllers;

use App\Models\Intent;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntentController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $queryBuilder = Intent::query();
        try {
            $this->buildOrder($request, $queryBuilder);
        } catch (\InvalidArgumentException $e) {
            return response()->json('Invalid order by supplied', 400);
        }

        return response()->json($queryBuilder->limit(4)->get());
    }

    /**
     * @param Request $request
     * @param Builder $queryBuilder
     */
    private function buildOrder(Request $request, Builder $queryBuilder): void
    {
        foreach ($request->get('orderBy', ['title']) as $order) {
            if (is_string($order)) {
                // If we ever need more special orders
                switch ($order) {
                    case 'answers_count':
                        $queryBuilder->withCount('answers');
                        $queryBuilder->orderBy('answers_count', 'desc');
                        break;
                    default:
                        $queryBuilder->orderBy($order);
                }
            } else {
                throw new InvalidArgumentException();
            }
        }
    }
}
