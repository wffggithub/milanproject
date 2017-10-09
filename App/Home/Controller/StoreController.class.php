<?php
namespace Home\Controller;

use Think\Controller;

class StoreController extends ComController
{
    /**
     * 门店展示
     */
    public function index()
    {

        if (I('pid') == 0) { //默认显示第一个二级导航数据
            $pid = I('id');
            $channel_id = M('category')->where(['pid'=>$pid])->order('o asc')->getField('id');
        } else {
            $pid = I('pid');
            $channel_id = I('id'); //导航id
        }

        $this->assign('channel_id',$channel_id); //需要高亮的二级导航id
        // TODO 获取banner  pc图
        $bannerPC = M('banner')->field('image_path')->where(['is_position'=>0,'sid'=>$pid])->order('o desc')->find();
        $this->assign('bannerPC',empty($bannerPC) ? [] :  $bannerPC);

        //获取所有二级导航
        $cate_id = M('category')->where(['dir'=>'Store','pid'=>0])->getField('id'); //获取产品中心导航id
        $store_cate = M('category')->where(['pid'=>$cate_id])->order('o asc')->select();
        $store = M('store')->field('id,sid,image_path')->where(['sid'=>$channel_id])->select();

        $this->assign('store_cate',empty($store_cate) ? [] : $store_cate);
        $this->assign('store',empty($store) ? [] : $store);

        $this->display();
    }

}