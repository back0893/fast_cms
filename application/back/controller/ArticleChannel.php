<?php
/**
 * Created by PhpStorm.
 * User: WX-C
 * Date: 2018/2/6
 * Time: 14:44
 */

namespace app\back\controller;


use app\back\model\Channel;

class Channels extends Base
{
    public function index(){
        $channel=new Channel();
        $this->assign('channel',$channel);
        return $this->fetch();
    }
}