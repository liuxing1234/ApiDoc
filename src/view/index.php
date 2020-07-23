<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Api 接口文档</title>
    <link rel="stylesheet" href="<?php echo $css;?>">

</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">接口文档</div>
    </div>
    <div >
       <!--下面是文档展示区-->
        <?php
        //目录的分类
        foreach($info as $k=>$v){
            ?>
            <blockquote class="layui-elem-quote layui-text" style="margin-top: 10px;"><b>命名空间： <?php echo $k;?></b></blockquote>
            <?php
            //这下面是类的循环
            foreach($v as $kk=>$vv){
                $class_name_total = $vv["name"];
                $classTemp = explode("\\",$class_name_total);
                $className = end($classTemp); //类名称
                $classTemp1 = $classTemp;
                array_pop($classTemp1);
                $namespace = implode("\\",$classTemp1);
                $classDoc = $vv["class_doc"]??"";
                $classDocDesc = $classDoc["desc"]??""; //类描述
                $classTags = $classDoc["tags"]??"";
                $methods = isset($vv["methods"])?$vv["methods"]:"";
                $filePosition = isset($vv["file_position"])?$vv["file_position"]:'';
                ?>
                <div style="margin:10px;">
                    <div class="layui-collapse" style="margin:0px; padding: 0px;" >
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">类名:<b style="color: #FF534D;"> <?php echo $className;?></b></h2>
                            <div class="layui-colla-content">

                                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                    <legend>类:</legend>
                                </fieldset>
                                <form class="layui-form layui-form-pane" action="">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">类描述:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="username"  value="<?php echo $classDocDesc;?>"  class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">命名空间:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="username"  value="<?php echo $namespace;?>"  class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">文件位置:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="username"  value="<?php echo $filePosition;?>"  class="layui-input">
                                        </div>
                                    </div>
                                </form>
                                <!-- 方法的列表-->
                                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                                    <legend>方法:</legend>
                                </fieldset>
                                <form class="layui-form layui-form" action="">

                                    <?php
                                    foreach($methods as $method){
                                        $methodName = $method["method_name"];
                                        $methodModifiers = $method["method_modifiers"];
                                        $method_doc_arr = $method["method_doc_arr"]; //method的标签
                                        $methodDesc = $method_doc_arr["desc"];
                                        $methodTags = $method_doc_arr["tags"]??"";

                                        ?>
                                        <div class="layui-collapse" lay-filter="test" >
                                            <div class="layui-colla-item">
                                                <h2 class="layui-colla-title">方法名: <b style="color: #25C6FC;"><?php echo $methodName;?></b></h2>
                                                <div class="layui-colla-content">
                                                    <form class="layui-form" action="">
                                                        <div class="layui-form-item">
                                                            <label class="layui-form-label">方法名</label>
                                                            <div class="layui-input-block">
                                                                <input type="text" name="title"  lay-verify="title" autocomplete="off" value="<?php echo $methodName;?>" class="layui-input">
                                                            </div>
                                                        </div>
                                                        <div class="layui-form-item">
                                                            <label class="layui-form-label">方法描述</label>
                                                            <div class="layui-input-block">
                                                                <input type="text" name="title" lay-verify="title" autocomplete="off" value="<?php echo $methodDesc;?>" class="layui-input">
                                                            </div>
                                                        </div>
                                                        <div class="layui-form-item">
                                                            <label class="layui-form-label">方法修饰符</label>
                                                            <div class="layui-input-block">
                                                                <?php
                                                                if($methodModifiers){
                                                                    foreach($methodModifiers as $modifier){
                                                                        if($modifier=="public"){
                                                                            echo "<button type='button' value='test'  class=\"layui-btn \">".$modifier."</button>";
                                                                        }elseif ($modifier=="private"){
                                                                            echo "<button type='button' value='test'  class=\"layui-btn layui-btn-danger\">".$modifier."</button>";
                                                                        }else if($modifier=="protect"){
                                                                            echo "<button type='button' value='test'  class=\"layui-btn  layui-btn-normal\">".$modifier."</button>";
                                                                        }else if($modifier=="static"){
                                                                            echo "<button type='button' value='test'  class=\"layui-btn layui-btn-warm\">".$modifier."</button>";
                                                                        }else{
                                                                            echo "<button type='button' value='test'  class=\"layui-btn\">".$modifier."</button>";
                                                                        }
//
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div>
                                                    <?php if($methodTags){?>
                                                        <table class="layui-table">
                                                            <tr class="layui-bg-cyan">
                                                                <td>参数名</td>
                                                                <td>数据类型</td>
                                                                <td>变量名</td>
                                                                <td>描述</td>
                                                            </tr>
                                                            <?php
                                                            //遍历method的参数标签

                                                                foreach($methodTags as $methodTag){
                                                                    $methodTagName = $methodTag["tag"]??"";
                                                                    $methodTagType = $methodTag["type"]??"";
                                                                    $methodTagVar  = $methodTag["var"]??"";
                                                                    $methodTagDesc = $methodTag["desc"]??"";
                                                                    echo "<tr>";
                                                                    echo "<td>$methodTagName</td>";
                                                                    echo "<td>$methodTagType</td>";
                                                                    echo "<td>$methodTagVar</td>";
                                                                    echo "<td>$methodTagDesc</td>";
                                                                    echo "</tr>";
                                                                }

                                                            ?>

                                                        </table>
                                                    <?php }?>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>

        <?php }} ?>




    </div>

</div>
<script src="<?php echo $js;?>"></script>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>