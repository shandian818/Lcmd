# Lcmd

## CS通信协议
使用json传输数据,格式暂定。
```
{
    "action":"test",
    "controller":index
}
```

## 错误码
|code|message|
|:---|:------|
|101|参数错误 如请输出正确的参数|
|102|扩展错误 如“请先安装swoole扩展”|
|201|权限错误 如“配置文件没有写权限”|
