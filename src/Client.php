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
    protected $opt = [];

    public function __construct()
    {
        $this->opt = Option::$scanArr;
    }

    public function set($arr=[]){
        if(is_array($arr)){
            $this->opt = $arr;
        }else{
            return "不是数组";
        }
    }
    /**
     * 展示页面
     */
    public function show($type=1)
    {
        $info = $this->create();
        if($type==2){
            $path = __DIR__.DIRECTORY_SEPARATOR."view".DIRECTORY_SEPARATOR."tpl.php";///home/wwwroot/demo.com/src
        }else{
            $js = Option::$js;
            $css = Option::$css;
            $path = __DIR__.DIRECTORY_SEPARATOR."view".DIRECTORY_SEPARATOR."index.php";///home/wwwroot/demo.com/src
            $static = __DIR__.DIRECTORY_SEPARATOR."static".DIRECTORY_SEPARATOR."layui";///home/wwwroot/demo.com/src
        }

        include_once $path;



    }
    public function create()
    {
        $list = $this->opt;
        $finalArr = [];
        foreach($list as  $k=>$v)
        {
            $doc = $this->getDocs($k,$v);
            $finalArr[$k] = $doc;
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
                if($doc){
                    array_push($docArr,$doc);
                }

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
        try{
            $reflection = new \ReflectionClass($objName);
            $file_position = $reflection->getFileName();
            //类的注释
            $class_doc_str = $reflection->getDocComment();
            $class_doc_arr = $this->match($class_doc_str);

            $finalArr["name"] = $reflection->getName();
            $finalArr["class_doc"] = $class_doc_arr;
            $finalArr["file_position"] = $file_position;

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
        }catch (\Throwable $e){
            echo $e->getMessage();
        }
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
                        if(count($temp)==2){
                            $tag = [
                                "tag" =>isset($temp[0])?$temp[0]:"",
                                "var" =>isset($temp[1])?$temp[1]:"",
                                "type" =>"",
                                "desc" =>"",
                            ];
                        }else{
                            //PARAM STRING $DESC 描述
                            //要对第二个类型进行检测
                            $typeName = "";
                            $tag = array_shift($temp);
                            $type = array_shift($temp);
                            $var =  array_shift($temp);
                            $desc = implode(" ",$temp);

                            switch($type){
                                case "string":
                                case "str":
                                case "int":
                                case "number":
                                case "integer":
                                case "bool":
                                case "boolean":
                                case "mix":
                                case "mixed":
                                case "object":
                                case "obj":
                                case "array":
                                case "arr":
                                    $typeName=$type;
                                    break;
                                default:
                                    $typeName = "";
                            }
                            $tag = [
                                "tag" =>isset($tag)?$tag:"",
                                "type"=>isset($typeName)?$typeName:"",
                                "var" =>isset($var)?$var:"",
                                "desc"=>isset($desc)?$desc:""
                            ];
                        }

                        // param miaoshu


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