<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SimpleXMLElement;

class MainController extends Controller
{
    
    public function index()
    {
        //$this->getInfo();
        $streamurl = env('STREAM_SERVER_URL').'stream';
        $info = $this->getInfo();

        return view('index', [
            'streamurl' => $streamurl,
            'currentsong' => $info['SONGTITLE'],
            'nextsong' => $info['NEXTTITLE'],
        ]);
    }

    public function getSongsInfo()
    {
        $info = $this->getInfo();
        return response()
            ->json(['currentsong' => $info['SONGTITLE'], 'nextsong' => $info['NEXTTITLE']]);
    }

    public function getInfo()
    {
        //http://35.216.174.122:8000/admin.cgi?mode=viewxml&page=1&sid=1?user=admin&pass=test1234
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://35.216.174.122:8000/admin.cgi?mode=viewxml&page=1&sid=1?user=admin&pass=test1234");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);        
        curl_close($ch);
        $oXML = new SimpleXMLElement($output);

        $info = [];
        foreach($oXML->children() as $key => $val) {
            $info[$key] = strval($val);
        }

        return $info;
    }

}
