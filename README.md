# 日志抽离

## 1. 安装扩展

```bash
composer require apigenerator/callmelx
```

## 2. 使用示例

```php
$client = new Client();
$opt = [
    //需要扫描的目录,格式为namespace=>local,键为命名空间,值为文件夹所在位置,可以配置多个  
];
$client->set($opt);
$client->show(); # 获取接口文档的展示页

$client->create(); # 通过create可以获取指定目录下所有注释,返回为数组形式
```

## 3. 目录结构

```shell
|--src
|----api # 后期如果扩展其他系统接口,均可写在这里
|----yapi #用于连接yapi的类库接口
|----yapiClient #用于连接yapi的客户端
|----config
|------Option.php  # 基本配置信息,包括默认扫描路径,静态资源的cdn地址等
|------YapiOpt.php # 第三方,用于连接yapi所需的配置项
|----view # 视图层
|----Client.php #抽取项目注释的客户端
```

