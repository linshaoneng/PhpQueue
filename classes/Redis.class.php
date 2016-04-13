<?php
/**
 * Created by PhpStorm.
 * User: shaoneng
 * Date: 15-9-14
 * Time: 下午4:39
 */
class Redis{
    public $redis ;
    public $key ;
    public $error;

    public function __construct( $key ){
        if( !class_exists('Redis')){
            return false;
        }
        $ip = REDIS_HOST;
        $pwd = REDIS_PASSWORD;
        $port = REDIS_PORT;
        $time_out = REDIS_TIME_OUT;
        $this->do_connect($ip, $port,$time_out);
        $this->key = $key;
    }

    /*
     * 连接函数，执行连接
     * 连接redis与选择数据库，并确认是否可以正常连接，连接不上就返回false
    */
    public function do_connect($ip ,$port=6379,$time_out=0.3){
        $this->redis = new Redis();
        try {
            $this->redis->connect($ip,$port,$time_out);
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 入队列
     */
    public function push( $value ){
        if( $this->redis==false &&  $this->key=='' ){
            $this->error  = 'redis conn error or key is null';
            return false;
        }
        try {
            return $this->redis->LPUSH( $this->key, $value);
        }catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 出队列
     */
    public function pop(){
        if( $this->redis==false &&  $this->key=='' ){
            $this->error  = 'redis conn error or key is null';
            return false;
        }
        try {
            return $this->redis->LPOP( $this->key );
        }catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function error(){
        return $this->error ;
    }
}