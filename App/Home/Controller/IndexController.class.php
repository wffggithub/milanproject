<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends ComController {

	//系统首页
    public function index()
    {

        //首页导航id
        $id = $this->home_channel_id;
        // TODO 获取banner  pc图
        $bannerPC = M('banner')->field('image_path')->where(['is_position'=>0,'sid'=>$id])->order('o desc')->find();
        $this->assign('bannerPC',empty($bannerPC) ? [] :  $bannerPC);

        //首页产品二级导航
        $cate_id = M('category')->where(['dir'=>'Product','pid'=>0])->getField('id'); //获取产品中心导航id
        $product_cate = M('category')->field('id,pid,name,link,image_path,description')->where(['pid'=>$cate_id])->order('o asc')->select();
        foreach ($product_cate as $k=>&$v){
            $v['description'] = mb_substr($v['description'],0,100,'utf-8');
        }
        $this->assign('product_cate',$product_cate);

        // TODO 获取首页热门推荐
        $hotData = M('product')->field('p.image_path,c.id,c.pid,c.link')->alias('p')->join('__CATEGORY__ c ON c.id=p.sid')
                                ->where(['is_hot'=>1])->order('t desc')->select();
        //dump($hotData);die;
        $this->assign('hotData',$hotData);

        //终端店铺形象
        $store = M('store')->field('id,sid,image_path')->where(['is_home'=>1])->select();
        $this->assign('store',empty($store) ? [] : $store);

        //获取视频地址
        $video = M('video')->order('t desc')->find();
        $this->assign('video',$video);
                 
        $this->display();
    }

}