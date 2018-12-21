<?php
/**
 * Created by PhpStorm.
 * User: 李坤霖
 * Date: 2018/12/14 0014
 * Time: 11:57
 */
namespace app\admin\controller;
use think\Request;
use app\common\lib\Upload;
$upload = new Upload();
var_dump($upload->image());
exit;
/**
 * 后台图片上传相关逻辑
 * @package app\admin\controller
 */
class Image extends Base
{
    public function upload0()
    {
    	$file = Request::instance()->file('file');
        // 把图片上传到指定的文件夹中
    	$info = $file->move('upload');
    	if ($info && $info->getPathname()) {
    		  $data = [
    		  	'status' => 1,
    		  	'message' => 'OK',
    		  	'data'  =>  '/'.$info->getPathname(),
             ];
             echo json_encode($data);exit;
    	}
       
        echo json_encode(['status'=>0,'message'=>'上传失败']);
    }
    /**
     * 七牛云图片上传
     */

    public function upload(){
        try {
            $image = Upload::image();
        }catch (\Exception $e) {
            echo json_encode(['status' => 0, 'message' => $e->getMessage()]);
        }
        if($image) {
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => config('qiniu.image_url').'/'.$image,
            ];
            echo json_encode($data);exit;
        }else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }
    }

    

}