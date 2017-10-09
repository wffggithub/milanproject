<?php

namespace Home\Controller;

use Think\Controller;

class JoinController extends ComController
{
    /**
     * 招商加盟
     */
    public function index()
    {
       /* // TODO 获取join  PC图
        $infoPC = M('withus')->field('image_path')->where(['is_position'=>0])->order('o asc')->select();
        $this->assign('infoPC',$infoPC);
        // TODO 获取join  m图
        $infoM = M('withus')->field('image_path')->where(['is_position'=>1])->order('o asc')->select();
        $this->assign('infoM',$infoM);*/

        $this->display();exit;
    }

}