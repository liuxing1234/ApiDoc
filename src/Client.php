<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/23
 * Time: 11:17
 */

namespace ApiGenerator;




use ApiGenerator\config\Option;

class Client
{
    public $opt = [];
    public $dir = "";

    public function __construct()
    {
        $this->create();

    }

    public function create()
    {
        $list = Option::$scanArr;
        $finalArr = [];
        foreach($list as  $k=>$v)
        {
            $doc = $this->getDocs($k,$v);
            $finalArr[] = $doc;
        }
        return $finalArr;
    }

    /**
     * 获取汇总的日志
     */
    public function getDocs($np,$dir)
    {
        $docArr = [];
        $this->scannerDir($dir,$np,$classArr);
        if($classArr){
            foreach($classArr as $v){
                $doc = $this->extract($v);
                array_push($docArr,$doc);
            }
            return $docArr;
        }else{
            die("该目录没有文件");
        }
    }

    /**
     * 抽离注释的
     */
    public function extract($objName)
    {
        $finalArr = [];
        $obj = new $objName;
        $reflection = new \ReflectionClass($obj);
        //类的注释
        $class_doc_str = $reflection->getDocComment();
        $class_doc_arr = $this->match($class_doc_str);

        $finalArr["name"] = $reflection->getName();
        $finalArr["class_doc"] = $class_doc_arr;

        $methods = $reflection->getMethods();
        $method_res = [];
        if($methods){
            foreach($methods as $method){
                //方法
                $method_name = $method->name;
                $method_doc  = $method->getDocComment();
                $method_modifiers = $this->modifier($method);
                $method_doc_arr   = $this->match($method_doc);
                $method_res[$method_name] = compact("method_name","method_modifiers","method_doc_arr");
            }
        }

        $finalArr["methods"]=$method_res;
        return $finalArr;

    }

    /**
     * 匹配match
     * @param string $doc
     * @return array
     */
    public function match($doc="")
    {
        $arr = explode("*",$doc);
        $arr = array_filter($arr);
        $desc = "";
        $tags = [];
        if(count($arr)>2){
            array_shift($arr);
            array_pop($arr);
            foreach($arr as $k=>$v){
                $v = trim($v);
                if($v)
                {
                    if(strpos($v, '@') === 0)
                    {

                        $v = trim($v,'@');
                        $temp = explode(" ",$v);
                        $temp = array_filter($temp);
                        $temp = array_values($temp);
                        $tag = [
                            "tag"=>$temp[0]?$temp[0]:"",
                            "type"=>$temp[1]?$temp[1]:"",
                            "var"=>$temp[2]?$temp[2]:"",
                            "desc"=>$temp[3]?$temp[3]:""
                        ];
                        $tags[] = $tag;

                    }else{
                        $desc.=$v;
                    }

                }
            }
        }

        $docArr=[
            "desc"=>$desc,
            "tags"=>$tags
        ];

        return $docArr;
    }

    public function modifier($method)
    {
        $type = [];
        if($method->isAbstract()){
            $type[]="abstract";
        }
        if($method->isFinal())
        {
            $type[]="final";
        }
        if( $method->isPrivate())
        {
            $type[]="private";
        }
        if( $method->isProtected())
        {
            $type[]="protected";
        }

        if( $method->isPublic())
        {
            $type[]="public";
        }

        if( $method->isStatic())
        {
            $type[]="static";
        }
        return $type;
    }
    /**
     * 扫描文件夹和文件夹的文件类
     * @param string $dir
     * @param array $classArr
     * @param bool $isAll
     */
    public function scannerDir($dir="",&$np="",&$classArr = [],$isAll=true,$isFirst=true)
    {
        $temp=scandir($dir);
        foreach($temp as $v){
            $name=$dir.'/'.$v;
            if(is_dir($name)){
                if($v=='.' || $v=='..'){
                    continue;
                }
                if($isAll)
                {
                    $new_dic = basename($name);
                    $new_np = $np."\\".$new_dic;
                    $this->scannerDir($name,$new_np,$classArr,$isAll,false);
                }
            }else{
                $pathinfo = pathinfo($name);
                $class_name = $pathinfo["filename"];
                $class_name = $np."\\".$class_name;
                $classArr[] = $class_name;
            }

        }
    }
}