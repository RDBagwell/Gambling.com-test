<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Cords;

class Affiliates extends Controller
{
    
    private $latitude;
    private $longitude;
    private $earthRadius;
    private $seachRadius;

    /** 
     * Using dependency injection to set variables
    **/
    public function __construct(
        private Cords $cords
    ) {
        $this->latitude = $cords->latitude;
        $this->longitude = $cords->longitude;
        $this->earthRadius = $cords->earthRadiusInKM;
        $this->seachRadius = $cords->radius;
    }

    /** 
     * Convert text to array on every line break. 
     * Convert json string to associative array.
     * Return new array with associative array. 
    **/
    private function convertListToArray($list){ 
        if(!$list) return "No file found.";
        
        $listArr = explode("\n", $list);
        $newArr = [];     
        foreach($listArr as $line ){
            $json = json_decode($line, true);
            $newArr[] = $json;
        }
        return $newArr;
    }


    private function degreesToRadians($degree){
        return deg2rad($degree);
    }

    private function getDistance($startCords, $endCords){
        $distance = acos(
            sin($startCords["latitude"]) * sin($endCords["latitude"]) +
            cos($startCords["latitude"]) * cos($endCords["latitude"]) * 
            cos($startCords["longitude"] - $endCords["longitude"])
        ) * $this->earthRadius;
        return $distance;
    }

    /** 
     * Take affiliates list and return a new list of affiliates in search radius
    **/
    private function getRadiusSeachResults($list){
        $listArr = $this->convertListToArray($list);
        $startLatRads = $this->degreesToRadians($this->latitude);
        $startLongRads = $this->degreesToRadians($this->longitude);
        $newList = [];

        // Save cords in array for convenience
        $startCords = array(
            "latitude" => $startLatRads,
            "longitude" => $startLongRads
        );

        foreach($listArr as $vlaue){
            $endLatRads = $this->degreesToRadians($vlaue['latitude']);
            $endLongRads = $this->degreesToRadians($vlaue['longitude']);

            // Save cords in array for convenience
            $endCords = array(
                "latitude" => $endLatRads,
                "longitude" => $endLongRads
            );
            $distance = $this->getDistance($startCords, $endCords); 
            if($distance <= $this->seachRadius){
                // Do it this way to usr ksort
                $newList[$vlaue['affiliate_id']] = $vlaue;
            }
        }
        // Easy way to sort by affiliate_id
        ksort($newList, SORT_NUMERIC);
        return $newList;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listTxt = Storage::disk('public')->get('affiliates.txt');
        $list = $this->getRadiusSeachResults($listTxt);
        return $list;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $fileName = "affiliates.txt";
        Storage::delete('public/' . $fileName);
        $request->validate([
            'file' => 'required|mimes:txt,json',
        ]);
        $request->file->storeAs('public', $fileName);
        return json_encode(array("Message"=> "Success"));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
