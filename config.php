<?php
/**
 * Created by PhpStorm.
 * User: shaoneng
 * Date: 16-4-13
 * Time: 下午12:35
 */
//---Redis 配置
define( 'REDIS_HOST', '127.0.0.1' );
define( 'REDIS_PORT', '6379' );
define( 'REDIS_PASSWORD', '' );
define( 'REDIS_TIME_OUT', '0.3' );
//---最大同时运行的进程数量
define( 'MAX_PROCESS', 2 );
//--如果获取到空数据，最多的重复次数
define( 'MAX_NULL_REPEAT', 20 );