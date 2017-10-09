<?php

namespace Home\Controller;

use Think\Controller;

class AboutController extends ComController
{
    /**
     * 关于我们
     */
    public function index()
    {
        if (I('pid') == 0) { //默认显示第一个二级导航数据
            $pid = I('id');
           if (empty($pid)) { //首页点击品牌简介
               $pid = M('category')->where(['dir'=>CONTROLLER_NAME,'pid'=>0])->getField('id');
           }
            $channel_id = M('category')->where(['pid'=>$pid])->order('o asc')->getField('id');
        } else {
            $pid = I('pid');
            $channel_id = I('id'); //导航id
        }

        $this->assign('channel_id',$channel_id); //需要高亮的二级导航id
        // TODO 获取banner图
        $bannerPC = M('banner')->field('image_path')->where(['is_position'=>0,'sid'=>$pid])->order('o desc')->find();
        $this->assign('bannerPC',empty($bannerPC) ? [] :  $bannerPC);


        //获取所有二级导航
        $cate_id = M('category')->where(['dir'=>'About','pid'=>0])->getField('id'); //获取产品新闻动态导航id
        $about_cate = M('category')->field('id,pid,name,link')->where(['pid'=>$cate_id])->order('o asc')->select();
        $this->assign('about_cate',empty($about_cate) ? [] : $about_cate);

        //内容
        $introduce = M('about')->field('id,sid,title,image_path,content')->where(['sid'=>$channel_id])->order('t desc')->find();
        $introduce['content'] = htmlspecialchars_decode($introduce['content']);
        $this->assign('introduce',empty($introduce) ? [] : $introduce);

        //获取视频地址
        $video = M('video')->order('t desc')->limit(0,2)->select();
        $this->assign('video',$video);

        $this->display();

    }
}

