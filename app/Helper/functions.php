<?php

/**
 *|--------------------------------------------------------------------------
 *| 公用函数文件
 *|--------------------------------------------------------------------------
 *|
 *| 函数命名字母之间使用下划线隔开
 *|
 **/


if (!function_exists('list_to_tree')) {
    /**
     * 递归树结构
     *
     * @param array $list 无层级数组
     * @param string $id 主键id
     * @param string $pid 父节点id
     * @param string $child 子集的名称
     * @param int $root 顶级节点id
     * @return array
     */
    function list_to_tree(array $list, string $id = 'id', string $pid = 'parent_id', string $child = 'children', int $root = 0): array
    {
        //创建Tree
        $tree = array();
        if (is_array($list)) {
            //创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$id]] = &$list[$key];
            }
            foreach ($list as $key => $data) {
                //判断是否存在parent
                $parantId = $data[$pid];
                if ($root == $parantId) {
                    $tree[] = &$list[$key];
                } else {
                    if (isset($refer[$parantId])) {
                        $parent = &$refer[$parantId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}
if (!function_exists('oddNum')) {
    /**
     * 用于唯一数生成
     * @param string|int $prefix 前缀
     * @param int $digit 随机数个数
     * @return string
     */
    function oddNum(string|int $prefix, int $digit): string
    {
        if ($digit < 2) {
            return "输入的数字不在范围内";
        }
        $small_number = pow(10, $digit - 1);
        $big_number = pow(10, $digit) - 1;
        $order_id_main = date('YmdHis') . rand($small_number, $big_number);
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        return $prefix . $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    }
}


if (!function_exists('success')) {
    function success($data = null)
    {
        return json_encode(['code' => 200, 'msg' => 'ok', 'data' => $data]);
    }

}

// API 失败信息返回封装
if (!function_exists('fail')) {
    function fail($msg = 'fail', $code = 400)
    {
        return json_encode(['code' => $code, 'msg' => $msg]);
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}