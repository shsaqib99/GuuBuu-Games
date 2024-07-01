<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    private $shopifyStore;
    private $apiVersion;
    private $accessToken;
    private $baseUrl;
    private $client;

    public function __construct($type)
    {
//        $type = "A";
        $settings = Settings::first();
        if ($type == 'A'){
            $this->shopifyStore = $settings->shopifyA_host;
            $this->accessToken = $settings->shopifyA_access_token;
            $this->apiVersion = $settings->shopifyA_api_version;
            $this->baseUrl = "https://" . $this->shopifyStore . "/admin/api/" . $this->apiVersion . "/";
        }else{
            $this->shopifyStore = $settings->shopifyB_host;
            $this->accessToken = $settings->shopifyB_access_token;
            $this->apiVersion = $settings->shopifyB_api_version;
            $this->baseUrl = "https://" . $this->shopifyStore . "/admin/api/" . $this->apiVersion . "/";
        }

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'X-Shopify-Access-Token' => $this->accessToken,
            ]
        ]);
    }

    private function parseLinkHeader($header_array)
    {
        $header = $header_array[0];
        $links = [];
        if ($header) {
            preg_match_all('/<([^>]+)>;\s*rel="([^"]+)"/', $header, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $links[$match[2]] = $match[1];
            }
        }
        return $links;
    }
    public function listProducts(Request $request){

        $pageUrl = $request->page_url;

        if (!$pageUrl) {
            $pageUrl = "products.json?limit=250";
        }

            $response = $this->client->request("GET",$pageUrl);

        if ($response->getStatusCode() != 200) {
            return $response;
        }


        $data = json_decode($response->getBody()->getContents(), true)['products'];

        $links = $this->parseLinkHeader($response->getHeader('link'));

        return ['data' => $data ,'links' => $links];

//        $header = $response->getHeader('link')[0];

//            $links = [];
//            $parts = explode(',', $header);

//            foreach ($parts as $part) {
//                $section = explode(';', $part);
//                $url = trim($section[0], '<> ');
//                $name = trim($section[1], 'rel=" ');
//
//                $links[$name] = $url;
//            }

        // Send the GET request
//        $response = $this->client->request("GET","products.json", [
//            'query' =>  [
////                'page_info' => $page,
//                'limit' => $limit,
//            ]
//        ]);

//        dd($response->getHeader('link'));

//        $link = explode(";",$response->getHeader('link'));

//        return response()->json([
//            'data' => $response->getBody()->getContents(),
//            'current_page' => $products->currentPage(),
//            'last_page' => $response->getBody()->getContents(),
//            'next_page_url' => $link[0],
//            'prev_page_url' => $response->getBody()->getContents(),
//            'per_page' => "250",
//        ]);

//        return json_decode($response->getBody()->getContents(), true)['products'];

    }
    public function createProduct($data){

        // Send the post request
//        dd($data);
        try {

            $response = $this->client->request("POST","products.json",
                [
                    "json" => $data
                ]);

            $statusCode = $response->getStatusCode();
            $responseData = $response->getBody()->getContents();

            return [
                'success' => true,
                'status_code' => $statusCode,
                'data' => json_decode($responseData, true)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

    }

}
