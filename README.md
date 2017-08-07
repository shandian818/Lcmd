# Lcmd

## 依赖

1. swoole扩展大于等于1.9.11
2. php版本大于等于7.0.0

## 启动命令
```
Usage:   php start.php -h HOST -p PORT -t TYPE

-h       HOST    Server hostname (ex: 127.0.0.1).
-p       PORT    Server port (ex: 9501).
-t       TYPE    Socket type (ex: websocket), support[websocket, tcp, http].
```

## CS通信协议
使用json传输数据,格式暂定。
```
{
    "action":"test",
    "controller":"index"
}
```

## 错误码
|code|message|
|:---|:------|
|101|参数错误 如请输出正确的参数|
|102|扩展错误 如“请先安装swoole扩展”|
|201|权限错误 如“配置文件没有写权限”|
|301|程序内部错误 如“路由注册失败”|
