# 接口文档
<?php
echo "<br>";
//目录的分类
foreach($info as $k=>$v){
?>

## 命名空间： <?php echo $k."<br>"?>

<?php
    //这下面是类的循环
    foreach($v as $kk=>$vv){
        $class_name_total = $vv["name"];
        $classTemp = explode("\\",$class_name_total);
        $className = end($classTemp); //类名称
        $classDoc = $vv["class_doc"]??"";
        $classDocDesc = $classDoc["desc"]??""; //类描述
        $classTags = $classDoc["tags"]??"";

        if(is_array($classTags && $classTags)){
            //类没有参数
        }

        $class_name = $vv["name"];
        $methods = $vv["methods"]??"";

        echo "<br>";
//        var_dump($methods);
        //遍历方法methods

?>
### 类名：<?php echo $className."<br/>";?>
**类描述:** <?php echo $classDocDesc."<br/>";?>
<?php
        foreach($methods as $method){
            echo "<hr>";
            $methodName = $method["method_name"];
            $methodModifiers = $method["method_modifiers"];
            $method_doc_arr = $method["method_doc_arr"]; //method的标签
            $methodDesc = $method_doc_arr["desc"];
//            var_dump($methodDesc);
            $methodTags = $method_doc_arr["tags"]??"";
            //遍历method的参数标签
            if(is_array($methodTags && $methodTags)){
                foreach($methodTagS as $methodTag){
                    $methodTagName = $methodTag["tag"]??"";
                    $methodTagType = $methodTag["type"]??"";
                    $methodTagVar  = $methodTag["var"]??"";
                    $methodTagDesc = $methodTag["desc"]??"";
                }
            }


            echo "<hr>";
        }
    }
?>

<?php } ?>
