<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/11
 * Time: 19:35
 */
namespace app\admin\controller;
use think\facade\Request;
use think\Controller;

class Article extends Base{
    public function article(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();
        $article=db('article');

        Request::filter(['strip_tags','htmlspecialchars','trim']);
        $cateid=Request::param("cateid");
        $keywords=Request::param("keywords");

        if(Request::isGET()){
            $map2=array(
                ['title','like','%'.$keywords.'%'],
                ['is_delete','=',0],
            );
            $map3=array(
                ['cateid','=',$cateid],
                ['title','like','%'.$keywords.'%'],
                ['is_delete','=',0],
            );
            /**
             * 文章查询功能
             * $count 该文章数量
             * $map   文章内容
             */
            if($cateid==0){
                if(!empty($keywords)){
                    $count=$article->where($map2)->count();
                    $map=$article->where($map2);
                }else{
                    $count=$article->where("is_delete=0")->count();
                    $map=$article->where("is_delete=0");
                }
            }else{
                if(!empty($keywords)){
                    $count=$article->where($map3)->count();
                    $map=$article->where($map3);
                }else{
                    $count=$article->where("cateid='$cateid' and is_delete=0")->count();
                    $map=$article->where("cateid='$cateid' and is_delete=0");
                }
            }
            if($count==0){
                $this->redirect('Article/error_sch',['keywords'=>$keywords],302);
                exit;
            }
            $list=$map->order("renew_date desc")->paginate($listRows=5,$simple=false,$config=
                [
                    'query'=>array(
                        'keywords'=>$keywords,
                        'cateid'=>$cateid,
                        ),
                    'type'      => 'page\Page',
                    'var_page'  => 'page',
                ]);
        }

        $this->assign(array(
            'list'=>$list,
            'cate'=>$cate,
            'keywords'=>$keywords,
            'url'=>'Article/article',
        ));// 赋值数据集

        return view();
    }

//    public function addtopage(){
//        $file = request()->file('smallimg');
//        $info = $file->validate(['size'=>50000,'ext'=>'jpg,png,jpeg,bmp'])->move($_SERVER['DOCUMENT_ROOT'].'/static/uploads/');
//        $a=$info->getFilename();
//        $imgp= str_replace("\\","/",$a);
//        $imgpath='/static/uploads/'.date('Ymd').'/'.$imgp;
//        $banner_img= $imgpath;
//        $response = array();
//        if($info){
//            $response['isSuccess'] = true;
//            $response['smallimg'] = $imgpath;
//        }else{
//            $response['isSuccess'] = false;
//        }
//
//        echo json_encode($response);
//
//    }
    public function error_sch(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();
        if(Request::param('status')){
            return view('error',['keywords'=>Request::param('keywords'),'brush'=>1])->assign('cate',$cate);
        }else{
            return view('error',['keywords'=>Request::param('keywords'),'url'=>'Article/article','brush'=>2])->assign('cate',$cate);
        }

    }

    public function add_article(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();

        if(Request::isPOST()){
            $data=Request::param(true);//true 获取所有
            $file = $data['smallimg'];

            //ajax返回页面原图
            if(Request::isAjax()){
                $info = $file->validate(['size'=>1048576,'ext'=>'jpg,png,jpeg,bmp'])->move($_SERVER['DOCUMENT_ROOT'].'/static/uploads/');
                $imgName=$info->getFilename();
                $imgp= str_replace("\\","/",$imgName);
                $imgpath='/static/uploads/'.date('Ymd').'/'.$imgp;
                $response = array();
                if($info){
                    $response['isSuccess'] = true;
                    $response['smallimg'] = $imgpath;
                }else{
                    $response['isSuccess'] = false;
                }
                echo json_encode($response);
                exit;
            }

            if(!empty($data['cateid'] && $data['title'] && $data['author'] && $data['content'])) {
                $today_thumb = $_SERVER['DOCUMENT_ROOT'] . '/static/uploads/' . date("Ymd") . '/';
                $img_info = $file->validate(['size' => 1048576, 'ext' => 'jpg,png,jpeg,bmp']);
                if ($img_info) {
                    $image = \think\Image::open(Request::file('smallimg'));
//                    if(!is_dir($today_thumb)){
//                        mkdir($today_thumb,0777);
//                    }
                    $img_name = mt_rand(1, 9999) . date('His') . '_thumb.jpg';

                    $image->thumb(150, 150)->save($today_thumb . $img_name);
                    $cate_name = db('category')->where('id=' . $data['cateid'])->field('c_name')->find();
                    $data = [
                        'cate_name' => $cate_name['c_name'],
                        'smallimg' => date("Ymd") . '/' . $img_name,
                        'renew_date' => date("Y-m-d H:i:s"),
                        'content' => $data['content'],
                        'title' => $data['title'],
                        'author' => $data['author'],
                        'cateid' => $data['cateid'],
                    ];
                    $success = db('article')->insert($data);
                    if($success){
                        $this->success('添加文章成功！', '/index.php/Admin/Article/article');
                    }
                }else{
                    $this->error('不能上传jpg,png,jpeg以外的图片');
                }
            }else{
                $this->error('请务必填写相应的内容');
            }
        }
        $this->assign('cate',$cate);//分类名称
        return view();
    }

    public function modify(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();

        if(Request::isGET()){
            $data=Request::param(true);

            for($i=0;$i<count($cate);$i++){
                if($data['cate_name']==$cate[$i]['c_name']){
                    unset($cate[$i]);
                }
            }

            $this->assign('id',$data['id']);
            $this->assign('title',$data['title']);
        }else{
            $data=Request::param(true);
            $c_name=db('category')->where('id',$data['cateid'])->field('c_name')->find();
            $suc=db('article')->where('id',$data['id'])->update([
                'title'=>$data['title'],
                'cateid'=>$data['cateid'],
                'cate_name'=>$c_name['c_name'],
                ]);
            if($suc){
                $this->success('修改文章成功！','/index.php/Admin/Article/article');
            }
        }
        $this->assign('cate',$cate);
        return view();
    }

    public function delete(){
        if(Request::isGET()){
            $data=Request::param(true);

            $is_del=db('article')->where('id',$data['id'])->update(['is_delete'=>1,]);

            if($is_del){
                $this->success('删除文章成功','/index.php/Admin/Article/article');
            }else{
                $info=db('article')->where('id',$data['id'])->field('smallimg')->find();

                if($info['smallimg'])
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].$info['smallimg']);
                }
                $real_delete = db('article')->where('id',$data['id'])->delete();//拿到回收箱传来的id，然后做真正的删除

                if($real_delete){
                    $this->success('删除成功！','/index.php/Admin/Article/brush');
                }else{
                    $this->success('删除失败！','/index.php/Admin/Article/brush');
                    exit;
                }
            }
        }
    }

    public function brush(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();
        $article=db('article');

        if(Request::isGet()){
            Request::filter(['strip_tags','htmlspecialchars','trim']);
            $keywords=Request::param('keywords');
            $cateid=Request::param('cateid');

            $map2=array(
                ['title','like','%'.$keywords.'%'],
                ['is_delete','=',1],
            );
            $map3=array(
                ['cateid','=',$cateid],
                ['title','like','%'.$keywords.'%'],
                ['is_delete','=',1],
            );
            /**
             * 文章查询功能
             * $count 该文章数量
             * $map   文章内容
             */
            if($cateid==0){
                if(!empty($keywords)){
                    $count=$article->where($map2)->count();
                    $map=$article->where($map2);
                }else{
                    $count=$article->where("is_delete=1")->count();
                    $map=$article->where("is_delete=1");
                }
            }else{
                if(!empty($keywords)){
                    $count=$article->where($map3)->count();
                    $map=$article->where($map3);
                }else{
                    $count=$article->where("cateid='$cateid' and is_delete=1")->count();
                    $map=$article->where("cateid='$cateid' and is_delete=1");
                }
            }
            if($count==0){
                $this->redirect('Article/error_sch',['keywords'=>$keywords,'status'=>400],302);
                exit;
            }
            $list=$map->order("renew_date desc")->paginate($listRows=5,$simple=false,$config=
                [
                    'query'=>array(
                        'keywords'=>$keywords,
                        'cateid'=>$cateid,
                    ),
                    'type'      => 'page\Page',
                    'var_page'  => 'page',
                ]);
        }

        $this->assign(array(
            'list'=>$list,
            'cate'=>$cate,
            'keywords'=>$keywords,
            'url'=>'Article/brush',
        ));
        return view();
    }

    public function reduction(){
        if(Request::isGet()){
            $data=Request::param(true);
            $suc=db('article')->where('id',$data['id'])->update(['is_delete'=>0,]);

            if($suc){
                $this->success('成功还原','/index.php/admin/Article/article');
            }
        }
    }
}