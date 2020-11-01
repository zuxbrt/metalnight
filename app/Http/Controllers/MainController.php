<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SimpleXMLElement;

class MainController extends Controller
{
    
    public function index()
    {
        $streamurl = env('STREAM_SERVER_URL').'/stream';
        $info = $this->getInfo();
        
        $currentsong = '';
        $nextsong = '';

        $streamactive = true;
        if($info['SERVERURL'] === ""){
            $streamactive = false;
        } else {
            $currentsong = $info['SONGTITLE'];
            $nextsong = isset($info['NEXTTITLE']) ? $info['NEXTTITLE'] : '';
        }

        if(!$info){
            $streamactive = false;
        }

        return view('index', [
            'streamurl' => $streamurl,
            'currentsong' => $currentsong,
            'nextsong' => $nextsong,
            'streamactive' => $streamactive,
            'listeners' => $info['CURRENTLISTENERS']
        ]);
    }

    public function getSongsInfo()
    {
        $info = $this->getInfo();
        $currentsong  = $info['SONGTITLE'];
        $nextsong = isset($info['NEXTTITLE']) ? $info['NEXTTITLE'] : null;
        return response()
            ->json(['currentsong' => $currentsong, 'nextsong' => $nextsong]);
    }

    public function getInfo()
    {
        //http://35.216.174.122:8000/admin.cgi?mode=viewxml&page=1&sid=1?user=admin&pass=test1234
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, env('STREAM_SERVER_URL')."/admin.cgi?mode=viewxml&page=1&sid=1?user=admin&pass=tests1234");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);        
        curl_close($ch);
        if($output){
            $oXML = new SimpleXMLElement($output);

            $info = [];
            foreach($oXML->children() as $key => $val) {
                $info[$key] = strval($val);
            }
    
            return $info;
        }
        return null;
        
    }

}
