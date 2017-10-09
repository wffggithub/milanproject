<?php
namespace Home\Controller;

use Think\Controller;

class ProductController extends ComController
{
    /**
     * 产品中心
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
        $cate_id = M('category')->where(['dir'=>CONTROLLER_NAME,'pid'=>0])->getField('id'); //获取产品中心导航id
        $product_cate = M('category')->field('id,pid,name,link')->where(['pid'=>$cate_id])->order('o asc')->select();

        //获取产品数据
        $product =M('product')->field('id,sid,image_path')->where(['sid'=>$channel_id])->order('t desc')->limit(0,10)->select();

        $this->assign('product_cate',empty($product_cate) ? [] : $product_cate);
        $this->assign('product',empty($product) ? [] : $product);

        // TODO 获取热门推荐
        $hotData = M('product')->field('p.image_path,c.id,c.pid,c.link')->alias('p')->join('__CATEGORY__ c ON c.id=p.sid')
            ->where(['is_hot'=>1])->order('t desc')->select();
        //dump($hotData);die;
        $this->assign('hotData',$hotData);

        $this->display('product');

    }

    /**
     * 产品列表
     */
    public function productList()
    {
        $type_id = I('type_id','0','intval');
        $data = M('product')->where(['type_id'=>$type_id])->order('t desc')->select();
        $this->assign('data',$data);
        $this->display();

    }


}