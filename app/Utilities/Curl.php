<?php

namespace App\Utilities;
/**
 * This is a CURL wrapper that I wrote for another project
 * It's light weight compared to Guzzle, and performs everything I need.
 */
class Curl
{
    private $curl = null;

    private $url;

    private $err;

    private $header = null;

    private $headerArr = [];

    private $body;

    public function __construct($url = '')
    {
        $this->initCurl();
        if(strlen($url) > 0) {
            $this->url($url);
        }
    }

    public static function init($url = '')
    {
        $curl = new static($url);

        return $curl;
    }

    private function initCurl()
    {
        if(!$this->keepAlive || $this->curl == null){
            $this->curl = curl_init();
        }

        $this->options = [];

        $this->setOption(CURLOPT_ENCODING, "")
            ->setOption(CURLOPT_ENCODING, "")
            ->setOption(CURLOPT_MAXREDIRS, 10)
            ->setOption(CURLOPT_MAXREDIRS, 10)
            ->setOption(CURLOPT_TIMEOUT, 30)
            ->setOption(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1)
            ->setOption(CURLOPT_HEADER, true)
            ->setOption(CURLOPT_CUSTOMREQUEST, "GET");
    }

    public function url($url)
    {
        $this->initCurl();

        $lastUrl = $this->url;

        $this->url = $url;

        $this->setOption(CURLOPT_URL, $this->url);

        if(isset($lastUrl) && is_string($lastUrl)){
            $this->setOption(CURLOPT_REFERER, $lastUrl);
        }
        
        $this->setOption(CURLOPT_HTTPHEADER, []);

        return $this;
    }

    public function withHeaders($headers = [])
    {
        if(!$headers) return $this;

        $headers = array_merge($this->options[CURLOPT_HTTPHEADER], $headers);

        $this->setOption(CURLOPT_HTTPHEADER, $headers);

        return $this;
    }

    public function postData($data, $urlEncode = true)
    {
        if(!$data) return $this;

        $this->setOption( CURLOPT_CUSTOMREQUEST, "POST");

        if(is_array($data) && $urlEncode)
        {
            $data = http_build_query($data);
        }

        $this->setOption(CURLOPT_POSTFIELDS, $data);
        
        return $this;
    }

    public function setData($data, $method = "GET")
    {
        if(!$data) return $this;

        if($method == "POST"){
            return $this->postData($data);
        }
        $join = "?";
        if(strpos($this->url, '?') !== false){
            $join = "&";
        }

        $url = $this->url. $join .http_build_query($data);

        $this->setOption(CURLOPT_URL, $url);

        return $this;
    }

    private $keepAlive = false;
    public function keepAlive($keep = true)
    {
        $this->keepAlive = $keep;

        return $this;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    protected $options = [];
    private function assignOptions()
    {
        curl_setopt_array($this->curl, $this->options);

        return $this;
    }

    public function setOptionsArray($array)
    {
        curl_setopt_array($this->curl, $array);

        return $this;
    }

    public function withCookies($cookieFileName = null)
    {

        return $this->setOption(CURLOPT_COOKIEJAR, $this->cookieFilename($cookieFileName))
            ->setOption(CURLOPT_COOKIEFILE, $this->cookieFilename($cookieFileName));
    }

    public function redirect($follow = true)
    {
        return $this->setOption(CURLOPT_AUTOREFERER, $follow)
                ->setOption(CURLOPT_FOLLOWLOCATION, $follow);
    }

    public function trackHeader($track = true)
    {
        return $this->setOption(CURLINFO_HEADER_OUT, $track);
    }

    private $cookieFileName = null;
    private function cookieFilename($cookieFileName=null)
    {
        if($this->cookieFileName == null){
            $this->cookieFileName = $cookieFileName ?: 'COOKIE_'.str_random(40);
        }

        return $this->cookieFileName;
    }

    public function getResponse()
    {
        if($this->err){
            return $this;
        }

        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        $this->assignOptions();
        $response = curl_exec($this->curl);
        $this->err = curl_error($this->curl);
        $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);

        if(!$this->keepAlive)
        {
            curl_close($this->curl);
        }

        if($this->err){
            dd($this->err);
            return $this;
        }

        $this->header = substr($response, 0, $header_size);
        $this->body = substr($response, $header_size);

        return $this;
    }

    public function close()
    {
        curl_close($this->curl);
    }

    public function getBody($format='')
    {
        if(!$this->body)
        {
            $this->getResponse();
        }

        if($format == 'json' || strpos($this->getHeader("Content-Type"), "application/json") !== false){
            try{
                return json_decode(trim($this->body), true);
            } catch(Exception $e) {

            }
        }

        return $this->body;
    }

    public function getJson()
    {
        return $this->getBody('json');
    }

    public function getHeaders()
    {
        if(!$this->header)
        {
            $this->getResponse();
        }

        if(count($this->headerArr) > 0)
        {
            return $this->headerArr;
        }
        
        $headerLines = explode("\r\n", $this->header);
        
        foreach($headerLines as $line)
        {
            $parts = explode(': ', $line);
            if(count($parts) != 2) continue;
            $this->headerArr[$parts[0]] = $parts[1];
        }

        return $this->headerArr;
    }

    public function getStatusCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    public function getHeader($key)
    {
        $headers = $this->getHeaders();

        if(!array_key_exists($key, $headers))
        {
            return "";
        }

        return $headers[$key];
    }
}
