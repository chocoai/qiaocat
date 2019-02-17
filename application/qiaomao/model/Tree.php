<?php namespace app\qiaomao\model;
/**
//使用方法

//原始数组
$a = array(
 array('id'=>1,'pid'=>0, 'name'=>'A'),
 array('id'=>2,'pid'=>1, 'name'=>'A1'),
 array('id'=>3,'pid'=>0, 'name'=>'B'),
 array('id'=>4,'pid'=>1, 'name'=>'A2'),
 array('id'=>5,'pid'=>2, 'name'=>'A1-1'),
 array('id'=>9,'pid'=>3, 'name'=>'B1'),
 array('id'=>7,'pid'=>3, 'name'=>'B2'),
 array('id'=>8,'pid'=>0, 'name'=>'C'),
 array('id'=>6,'pid'=>5, 'name'=>'A1-1-1'),
); 


//树型数组
$Tree = new Tree;
$t = $Tree->makeTreeArr($a,0,array('parent_id'=>'pid','level'=>'css'));

//格式化输出
foreach($t as $r)
{
	#echo $r['level'];
	for($i=0;$i <= $r['css']; $i++) echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	
	echo $r['id'], ',', $r['pid'], ',', $r['name'], '<br/>';
}

*/

class Tree
{	
	
	private $tree = array();
	
	/**
	 *@desc 生成树形数组
	 *@param top 顶层分类ID
	 *@param data 格式为 array[ 
	 *		         ['id'=>1, 'name'=>'name', 'parent_id'=>0,  'xxx'=>'yyy', ...], 
	 *		         ['id'=>2, 'name'=>'name', 'parent_id'=>1,  'xxx'=>'yyy', ...],
	 *		         ['id'=>xxx, 'name'=>xxx, 'parent_id'=>xxx, 'xxx'=>'yyy', ...]
	 *           ]
	 *@param $map 为不是标准格式的数组提供转换，格式为
     *            $map = ['id'=>'xxx_id', 'name'=>'xxx_name', 'parent_id'=>'xxx_parent_id', 'level'=>'level']
	 */
	public function makeTreeArr($data, $parentId=0, $map=array())
	{
		$map  = array_merge(array('id'=>'id', 'name'=>'name', 'parent_id'=>'parent_id', 'level'=>'level'),$map);
		
		$this->_makeTreeArr($data, $parentId, $map, 0 );
		return $this->tree;
	}
	
	/**
	 *@desc makeTreeArr的辅助函数
	 */
	protected function _makeTreeArr($data, $parentId, $m, $level)
	{
	
		foreach($data as $k => $d)
		{
			if($d[$m['parent_id']] == $parentId){
				$d[$m['level']] = $level;
				$this->tree[] = $d;
				$pid = $d[$m['id']];
				unset($data[$k]);
				$this->_makeTreeArr($data, $pid, $m, $level + 1);
			}
			
		}
	}
	
}

