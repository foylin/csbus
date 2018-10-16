<?php
namespace App\Api;

use PhalApi\Api;
// use PhalApi\CUrl;

/**
 * 公交线路模块
 */

class Lines extends Api
{

    protected $ticket = 'e42074deb71434856664adc873b45dcf';
    protected $header = array(
        'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
                // 'Accept' => 'text/html',
                // 'Connection' => 'keep-alive',
    );


    public function getRules()
    {
        return array(
            'search' => array(
                'linename' => array('name' => 'linename', 'source'=> 'post', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '线路名称')
            ),
            'getStation' => array(
                'lineid' => array('name' => 'lineid', 'source'=> 'post', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '线路名称')
            ),
            'getLineById' => array(
                'lineid' => array('name' => 'lineid', 'source'=> 'post', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '线路名称')
            ),
        );
    }
    
    /**
     * 线路查询
     *
     * @return void
     */
    public function search(){
        try {
            // var_dump($_REQUEST);
            // echo $this->linename;
            // exit();
            $cache_name = 'search_'.$this->linename;

            $data = \PhalApi\DI()->cache->get($cache_name);
            // var_dump($data);
            if(!empty($data)){
                
                return json_decode($data);
            }


            
            // 实例化时也可指定失败重试次数，这里是2次，即最多会进行3次请求
            $curl = new \PhalApi\CUrl();

            $ticket = $this->ticket;
            $url = 'http://183.232.33.171/BusAPI.asmx/GetLines?ticket='.$ticket;

            $param = array(
                'lineName' => $this->linename,
                'ticket' => $ticket
            );
            // 第二个参数为待POST的数据；第三个参数表示超时时间，单位为毫秒

            $header = array(
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
                // 'Accept' => 'text/html',
                // 'Connection' => 'keep-alive',
            );
            $curl->setHeader($header);

            $rs = $curl->post($url, http_build_query($param), 3000);

            // 一样的输出
            // echo $rs;exit();
            // return $rs;
            // $rs_deconde = json_decode($rs);
            if( strpos($rs, 'E3')){
                return array('msg'=> '数据错误，请稍后重试');
            }

            // return array('msg'=> '数据错误');

            // PhalApi\DI()->cache = new PhalApi\Cache\FileCache(array('path' => API_ROOT . '/runtime', 'prefix' => 'bus'));
            // 设置
            \PhalApi\DI()->cache->set($cache_name, $rs, 60*60*24*7);

            return json_decode($rs);
        } catch (\PhalApi\Exception\InternalServerErrorException $ex) {
            // 错误处理……
            // var_dump($ex);
            
        }

        // $ticket = 'e42074deb71434856664adc873b45dcf';
        // $url = 'http://183.232.33.171/BusAPI.asmx/GetLines?ticket='.$ticket;

        // $param = array(
        //     'lineName' => 6,
        //     'ticket' => $ticket
        // );

        // $header = array(
        //     'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
        //     // 'Accept' => 'text/html',
        //     // 'Connection' => 'keep-alive',
        // );

        // $curl = curl_init((string)$url);
        // curl_setopt($curl, CURLOPT_HEADER, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_TIMEOUT, 3000);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //添加自定义的http header
        // $rs = curl_exec($curl);
        // echo $rs;

        // var_dump($header);
    }

    /**
     * 线路站点信息
     *
     * @return void
     */
    public function getStation(){
        try {

            $cache_name = 'getStation_'.$this->lineid;

            $data = \PhalApi\DI()->cache->get($cache_name);
            // var_dump($data);
            // if(!empty($data) || !strpos($data, 'E3')){
                
            //     return json_decode($data);
            // }

            // 实例化时也可指定失败重试次数，这里是2次，即最多会进行3次请求
            $curl = new \PhalApi\CUrl();

            $ticket = $this->ticket;
            $lineid = $this->lineid;
            $url = 'http://183.232.33.171/BusAPI.asmx/GetStationLicense?ticket=' . $ticket . '&Lineid='.$lineid;

            $param = array(
                'lineid' => $lineid,
                'ticket' => $ticket,
                'upDown' => 1,
                'siteId' => ''
            );
            // 第二个参数为待POST的数据；第三个参数表示超时时间，单位为毫秒

            $header = array(
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
                // 'Accept' => 'text/html',
                // 'Connection' => 'keep-alive',
            );
            $curl->setHeader($header);

            $rs = $curl->post($url, http_build_query($param), 3000);

            // 一样的输出
            // echo $rs;
            // echo $rs[0];
            // exit();

            if( strpos($rs, 'E3')){
                return array('msg'=> '数据错误，请稍后重试');
            }

            // \PhalApi\DI()->cache->set($cache_name, $rs, 60*60*24*7);

            // return json_decode($rs);
        } catch (\PhalApi\Exception\InternalServerErrorException $ex) {
            // 错误处理……
            var_dump($ex);
        }
    }

    /**
     * 按线路id查询线路信息
     *
     * @return void
     */
    public function getLineById(){
        try {

            $cache_name = 'getlinebyid_'.$this->lineid;

            $data = \PhalApi\DI()->cache->get($cache_name);
            // var_dump($data);
            if(!empty($data)){
                
                return json_decode($data);
            }

            // 实例化时也可指定失败重试次数，这里是2次，即最多会进行3次请求
            $curl = new \PhalApi\CUrl();

            $ticket = $this->ticket;
            $lineid = $this->lineid;
            $url = 'http://183.232.33.171/BusAPI.asmx/GetLineById?ticket=' . $ticket . '&Lineid=' . $lineid;

            $param = array(
                'lineid' => $lineid,
                'ticket' => $ticket,
                // 'upDown' => 1,
                // 'siteId' => ''
            );
            // 第二个参数为待POST的数据；第三个参数表示超时时间，单位为毫秒

            $header = array(
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
                // 'Accept' => 'text/html',
                // 'Connection' => 'keep-alive',
            );
            $curl->setHeader($header);

            $rs = $curl->post($url, http_build_query($param), 3000);

            // 一样的输出
            // echo $rs;
            if( strpos($rs, 'E3')){
                return array('msg'=> '数据错误，请稍后重试');
            }

            \PhalApi\DI()->cache->set($cache_name, $rs, 60*60*24*7);

            return json_decode($rs);
        } catch (\PhalApi\Exception\InternalServerErrorException $ex) {
            // 错误处理……
            var_dump($ex);
            // return $ex['message'];

        }
    }



    public function GetLineNotice(){
        try {
            // 实例化时也可指定失败重试次数，这里是2次，即最多会进行3次请求
            $curl = new \PhalApi\CUrl();

            $ticket = $this->ticket;
            $lineid = '140724024716927';
            $url = 'http://183.232.33.171/BusAPI.asmx/GetLineNotice?ticket=' . $ticket . '&Lineid=' . $lineid;

            $param = array(
                'lineid' => $lineid,
                'ticket' => $ticket,
                'upDown' => 1,
                // 'siteId' => ''
            );
            // 第二个参数为待POST的数据；第三个参数表示超时时间，单位为毫秒

            $header = array(
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Linux; Android 5.0.2; Redmi Note 3 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Mobile Safari/537.36 Html5Plus/1.0',
                // 'Accept' => 'text/html',
                // 'Connection' => 'keep-alive',
            );
            $curl->setHeader($header);

            $rs = $curl->post($url, http_build_query($param), 3000);

            // 一样的输出
            // echo $rs;
            return json_decode($rs);
        } catch (\PhalApi\Exception\InternalServerErrorException $ex) {
            // 错误处理……
        }
    }

} 
