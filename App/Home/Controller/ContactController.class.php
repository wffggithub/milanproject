<?php

namespace Home\Controller;

use Think\Controller;

class ContactController extends ComController
{
    public function index()
    {
        if (I('pid') == 0) { //默认显示第一个二级导航数据
            $pid = I('id');
        } else { //从关于我们位置跳转来
            $pid = M('contact')->getField('sid');
            $pid = empty($pid) ? 57 : $pid;
        }

        // TODO 获取banner  pc图
        $bannerPC = M('banner')->field('image_path')->where(['is_position'=>0,'sid'=>$pid])->order('o desc')->find();
        $this->assign('bannerPC',empty($bannerPC) ? [] :  $bannerPC);


        $info = M('contact')->order('t desc')->find();
        $info['content'] = htmlspecialchars_decode($info['content']);
        $this->assign('info',$info);

        $this->display();exit;
    }
}