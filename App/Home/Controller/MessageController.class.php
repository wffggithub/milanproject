<?php
namespace Home\Controller;

use Think\Controller;

class MessageController extends ComController
{
    /**
     * 留言
     */
    public function index()
    {
        $data['name'] = I('name','','trim');
        $data['phone'] = I('phone','','trim');
        $data['message'] = I('message','','trim');
        if (empty($data['name']) && empty($data['phone']) && empty($data['message'])) {
            echo "<script>alert('请填写完整留言信息');window.history.go(-1)</script>";exit;
        }
        $data['t'] = time();
        $res = M('message')->add($data);
        if ($res) {
            $info['data'] = true;
            $this->success('留言成功',U('Index/index'));exit;
        }
        $this->success('留言失败，重新留言');exit;

    }
}