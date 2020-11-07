<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RestaurantController extends Controller
{
    /**
     * Find Restaurants
     * @param  Object {$request}    `keyword` : name of restaurant ,`next` : next page token 
     * @return Object "List of Restaurants and next page token"
     */
    public function find(Request $request)
    {   
        $results = Redis::get($request->redis_key);// Get restaurant from cache  ($request->redis_key : create from middleware "CheckType")
        // Redis::del($request->redis_key);
        if (empty($results)) { //Check result from cashe 
            $results = findPlace($request->keyword, $request->next);
            /** 
             * Check error and save to cash
             * save to cache when not error
             * throw status 500 and error_text when error
             */
            if (!isset($results["error"])) {
                if (count($results["results"]) > 0)
                    Redis::set($request->redis_key, json_encode($results));
            }else{
                return response()->json($results["error"], 500);
            }
        } else {// decode results from cache
            $results = json_decode($results);
            $results->is_cache = true;
        }
        return response()->json($results, 200);
    }
}
