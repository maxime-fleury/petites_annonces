<?php
class controllerManager
{
    private $controllers;
    private $baseUrl;
    private $dataDir;
    private $templateDir;
    public function __construct(){
        $this->baseUrl = "/post_ads/petites_annonces";
        $this->dataDir = "./data/";
        $this->templateDir = './templates/';
    }
    public function addRoute($path, $data, $dataReq, $tempReq){
        $this->controllers[$path] = array("data" => $data, "dataReq" => $dataReq, "tempReq" => $tempReq);
        return $this;
    }
    public function redirect(){
        $request = $_SERVER['REQUEST_URI'];
        $request_ = str_replace($this->baseUrl, "", $request);
        $request_ = explode("/", $request_);
        $found = false;
        if(!isset($request_[2]))
        foreach($this->controllers as $key => $value)
        {
            if( ($this->baseUrl . $key) === $request)
            {
                $found = true;
                if($value['data'] != null)
                {
                    foreach($value['data'] as $data)
                    {//load all data !
                        $da = explode("::", $data);
                        eval("\$$da[0] = '$da[1]'; ");
                        //echo "\$$da[0] = '$da[1]'; ";
                    }
                }
                if($value['dataReq'] != null)
                {
                    foreach($value['dataReq'] as $file)
                    {//load all data files !
                        require $this->dataDir . $file . ".php";
                        //echo $this->dataDir . $file . ".php";  
                    }
                }
                if($value['tempReq'] != null)
                {
                    foreach($value['tempReq'] as $file)
                    {//load all templates files !
                        require $this->templateDir . $file . ".php";
                        //echo $this->templateDir . $file . ".php";
                    }
                }
            }//works fine but lacks flexibility /test is a valid route, /test/lol isn't
            //now /test/$anything is a valid route
        }
        if(isset($request_[2]))
        foreach($this->controllers as $key => $value)
            {
                if( ($key) === "/".$request_[1])
                {
                    $found = true;
                    if($value['data'] != null)
                    {
                        foreach($value['data'] as $data)
                        {//load all data !
                            $da = explode("::", $data);
                            eval("\$$da[0] = '$da[1]'; ");
                            //echo "\$$da[0] = '$da[1]'; ";
                        }
                        //add new var, so if you go to /test/lol, $arg = "lol";
                    }
                    eval("\$arg = '$request_[2]';");//always check for $request_[2]
                    if($value['dataReq'] != null)
                    {
                        foreach($value['dataReq'] as $file)
                        {//load all data files !
                            require $this->dataDir . $file . ".php";
                            //echo $this->dataDir . $file . ".php";  
                        }
                    }
                    if($value['tempReq'] != null)
                    {
                        foreach($value['tempReq'] as $file)
                        {//load all templates files !
                            require $this->templateDir . $file . ".php";
                            //echo $this->templateDir . $file . ".php";
                        }
                    }
                }
            }
        if(!$found)
            require "./templates/404.php";
    }
}