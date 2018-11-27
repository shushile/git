<?php
namespace app\admin\controller;

class CategoryClass{
	public function getcatelist($id=0){
		$cate = db('category');
		$list = $cate->select();
		return $this->nolimitcategory($list,0,0,$id);
	}

	public function nolimitcategory($data,$parent_id=0,$level=0,$stop_id=0){
		static $list=array();
		foreach($data as $cate){
			if($cate['c_parent_id']==$parent_id && $cate['id']!=$stop_id){
				$cate['level']=$level;
				$list[]=$cate;
				$this->nolimitcategory($data,$cate['id'],$level+1,$stop_id);
			}
		}
		return $list;
	}
}
?>