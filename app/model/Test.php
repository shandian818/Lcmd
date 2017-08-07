<?php
/**
 * Test.php
 * 描述
 * User: lixin
 * Date: 17-8-7
 */

namespace app\model;


use core\BaseModel;

class Test extends BaseModel
{
    protected $connection = 'test';
    protected $table = 'test_version';
}