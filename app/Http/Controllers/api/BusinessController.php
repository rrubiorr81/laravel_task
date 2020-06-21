<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use GuzzleHttp;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    /**
     * Uses Yelp to get general info from a business.
     * @example {{LOCAL_SERVER}}api/getBusinessInfo/miami/lacarreta
     * @param $location
     * @param $term
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function getInfoBasedOnLocation($location, $term)
    {
        try {

            $validator = Validator::make(['location' =>$location, 'term' => $term], [
                'location' => 'required|min:2|max:255',
                'term' => 'required|min:2|max:255',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(), 'Validation Error']);
            }

            $client = new GuzzleHttp\Client(['base_uri' => config('app.YELP_URL')]);

            $headers = [
                'Authorization' => 'Bearer ' . config('app.YELP_API_KEY'),
                'Accept' => 'application/json',
            ];

            $response = $client->request('GET', 'businesses/search?term=' . $term . '&location=' . $location, [
                'headers' => $headers
            ]);

            return response(['message' => 'Info retrieved successfully', 'content' => json_decode($response->getBody()->getContents())], 200)->header('Content-Type', 'application/json');

        } catch (\Exception $exception) {
            return response(['message' => 'Error detected.', 'content' => []], 500);
        }
    }
}
