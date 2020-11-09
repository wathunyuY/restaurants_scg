<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

if (!function_exists('findPlace')) {
    /**
     * Google plcae API calling 
     * find restaurants by key or get get next page of restaurant
     * @param string $keyword keyword about restaurant example : `Bang sue`
     * @param bool $next String of next page token default false 
     * @return array|string List of restaurants or Error text when something wrong
     */
    function findPlace($keyword = "Bang sue", $next = false)
    {
        try {
            $API_KEY = env('GOOGLE_API_KEY', false);
            $request = env('GOOGLE_API_PLACE_HOST', false);
            $photo_request = env('GOOGLE_API_PHOTO_HOST', false);
            $default_photo = "https://dailycliparts.com/wp-content/uploads/2019/02/Restaurant-Icon-Download-1024x842.png";

            $params["key"]  = $API_KEY;
            if ($next) $params["pagetoken"] = $next;
            else {
                $params["query"] = "$keyword";
                $params["type"] = "restaurant";
            }

            $request .= http_build_query($params);
            $json = file_get_contents($request); // Call google place api
            $data = json_decode($json, true);
            $results = array("results" => [], "next" => null);
            if ($data["status"] == "OK" || $data["status"] == "ZERO_RESULTS") {
                $result = array();
                foreach ($data["results"] as $key => $val) { //Transform data
                    $result["place_id"] = Arr::get($val, "place_id", "");
                    $result["formatted_address"] = Arr::get($val, "formatted_address", "");
                    $result["geometry"] = Arr::get($val, "geometry", null);
                    $result["name"] = Arr::get($val, "name", "");
                    $result["photos"] = Arr::has($val, "photos.0.photo_reference") ? $photo_request . Arr::get($val, "photos.0.photo_reference") . "&key=" . $API_KEY : $default_photo;
                    $result["rating"] = Arr::get($val, "rating", 0);
                    $result["user_ratings_total"] = Arr::get($val, "user_ratings_total", 0);
                    array_push($results["results"], $result);
                }
                if (isset($data["next_page_token"])) $results["next"] = $data["next_page_token"]; //Set next page token
            } else {
                Log::emergency($data["status"]); // log error status from google api 
                throw new \Exception(getGoogleApiErrorText($data["status"]), 1);// Code 1 for flag google error text
            }
            return $results;
        } catch (Throwable $e) {
            throw new \Exception($e->getCode() === 1 ? $e->getMessage() : "Something was wrong please come back later."); // throw google status when code =1 then throw nomal text 
        }
    }
}

if (!function_exists('getCache')) {
    /**
     * Get cache from redis
     * @param string $key key of data
     * @return mixed saved data , false when data no found
     */
    function getCache($key)
    {
        try {
            $result = Redis::get($key);
            if (!empty($result)) return json_decode($result);
            return false;
        } catch (Throwable $e) {
            report($e); //Just loggin , Not throw error
        }
    }
}
if (!function_exists('setCache')) {
    /**
     * Save data to redis 
     * @param string $key key of data
     * @param mixed $data data to be save
     */
    function setCache($key = '', $data)
    {
        try {
            Redis::set($key, json_encode($data), 'EX', env('REDIS_EXPIRED', false)); // expire in 10 days
        } catch (Throwable $e) {
            report($e); //Just loggin , Not throw error
        }
    }
}

if (!function_exists('googleApiErrorText')) {
    /**
     * Get text of error
     * @param string $status error status from google place api
     * @return string Error text
     */
    function getGoogleApiErrorText($status)
    {
        $errors = [
            "OVER_QUERY_LIMIT" => 'over quota.',
            "REQUEST_DENIED" => 'Something was wrong please come back later.',
            "INVALID_REQUEST" => 'Something was wrong please come back later.',
            "UNKNOWN_ERROR" => 'Indicates a server-side error please trying again may be successful.'
        ];
        return $errors[$status];
    }
}
