<?php


$routesList = [];

class Route{
    public static function add($routeName,$pointControllerAction){
        $GLOBALS['routesList'][] = ['name'=>$routeName,'action'=>$pointControllerAction];
    }

    public static function run(){
        $request = $_SERVER['REQUEST_URI'];
        $request = explode("?",$_SERVER['REQUEST_URI'])[0];
        foreach($GLOBALS['routesList'] as $r){
            if($r['name']==$request){
                 return $r['action'];
            }
        }
     }
}