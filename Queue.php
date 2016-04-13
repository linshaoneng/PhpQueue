<?php
/**
 * Created by PhpStorm.
 * User: shaoneng
 * Date: 15-9-15
 * Time: 下午4:53
 */
include_once( dirname(dirname(__FILE__)).'/config.php' );
include_once( dirname(dirname(__FILE__)).'/classes/Redis.php' );

class Queue{

    public function __construct(){
        $this->__check_process();
    }

    /**
     * 运行入口函数
     */
    public function run(){
        //如果没有数据，最多尝试次数
        $null_repeat = 0;
        while( true ){
            $queue_data = $this->__get_queue();
            //如果队列里没数据，休息3秒钟
            if( $queue_data=='' ){
                sleep( 3 );
                $null_repeat++;
                echo " $null_repeat \r\n";
                if( $null_repeat>=MAX_NULL_REPEAT ){
                   break;
                }
            }else{
                $null_repeat = 0;
                $queue_data = json_decode( $queue_data, true );
                $this->dosomething( $queue_data );
            }
        }
    }

    /**
     * @param $queue_data
     * 要做的正紧事情
     */
    public function check_order_status( $queue_data ){
        echo " ---  --- \r\n";
        print_r( $queue_data );

    }

    /**
     * 获取队列信息
     */
    private function __get_queue(){
        $queue = new Queue( AGENT_COLLPAY_QUEUE_KEY );
        return $queue->pop();
    }

    /**
     * 检查进程数
     */
    private function __check_process(){
        $return = '';
        $class = __CLASS__;
        exec( 'ps aux|grep '.$class.'|wc -l', $return );
        $now_process = $return['0']-2;
        if( $now_process>MAX_PROCESS ){
            exit( '当前进程数:'.$now_process.' 终止~ PROCESS>MAX_PROCESS' );
        }
    }

}

$queue = new Queue();
$queue->run();