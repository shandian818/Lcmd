<?php
/**
 * code.php
 * 状态码
 * User: lixin
 * Date: 17-11-29
 */
// 成功响应
define('SUCCESS_RESPONSE', 1);

// 参数错误 如请输出正确的参数
define('PARAMS_ERROR', 101);

// 扩展错误 如“请先安装swoole扩展”
define('EXTENSION_ERROR', 102);

// 权限错误 如“配置文件没有写权限”
define('PERMISSION_ERROR', 201);

// 权限错误 如“配置文件没有写权限”
define('PROGRAM_ERROR', 301);