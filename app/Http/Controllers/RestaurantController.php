<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class RestaurantController extends Controller
{
    /**
     * Find Restaurants
     * @param  Request $request    `keyword` : name of restaurant ,`next` : next page token 
     * @return Object "List of Restaurants and next page token"
     */
    public function find(Request $request)
    {
        try {
            $results = getCache($request->redis_key); // Get restaurant from cache  ($request->redis_key : create from middleware "CheckType")
            if (!$results) { //Check result from cashe 
                $results = findPlace($request->keyword, $request->next);
                if (count($results["results"]) > 0) // save to cache
                    setCache($request->redis_key, $results);
            } else { // flag
                $results->is_cache = true;
            }
            return response()->json($results);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
