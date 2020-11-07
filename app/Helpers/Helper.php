<?php

if (!function_exists('findPlace')) {

    function findPlace($keyword = "Bang sue", $next = false)
    {
        try {
            $API_KEY = env('GOOGLE_API_KEY',false);
            $request = env('GOOGLE_API_PLACE_HOST',false);
            $photo_request = env('GOOGLE_API_PHOTO_HOST',false);

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
                    $result["place_id"] = $val["place_id"];
                    $result["formatted_address"] = isset($val["formatted_address"]) ? $val["formatted_address"] : '';
                    $result["geometry"] = isset($val["geometry"]) ? $val["geometry"] : null;
                    $result["icon"] = isset($val["icon"]) ? $val["icon"] : null;
                    $result["name"] = isset($val["name"]) ? $val["name"] : '';
                    $result["photos"] = isset($val["photos"]) && false ?  $photo_request . $val["photos"][0]["photo_reference"] . "&key=" . $API_KEY : "https://dailycliparts.com/wp-content/uploads/2019/02/Restaurant-Icon-Download-1024x842.png";
                    $result["rating"] = isset($val["rating"]) ? $val["rating"] : 0;
                    $result["user_ratings_total"] = isset($val["user_ratings_total"]) ? $val["user_ratings_total"] : 0;
                    array_push($results["results"], $result);
                }
                if (isset($data["next_page_token"])) $results["next"] = $data["next_page_token"]; //Set next page token
            } else {
                $results["error"] = $data["status"];
            }
            return $results;
        } catch (Throwable $e) {
            $results["error"] = "An error occurred in the server.";
            return $results;
        }
    }
}
