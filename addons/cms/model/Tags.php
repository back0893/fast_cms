<?php

namespace addons\cms\model;

use think\Model;

/**
 * 标签模型
 */
class Tags Extends Model
{

    protected $name = "tags";
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 追加属性
    protected $append = [
        'url',
        'fullurl'
    ];

    public function model()
    {
        return $this->belongsTo("Modelx");
    }

    public function getUrlAttr($value, $data)
    {
        $name = $data['name'] ? $data['name'] : $data['id'];
        return addon_url('cms/tags/index', [':id' => $data['id'], ':name' => $name]);
    }

    public function getFullurlAttr($value, $data)
    {
        $name = $data['name'] ? $data['name'] : $data['id'];
        return addon_url('cms/tags/index', [':id' => $data['id'], ':name' => $name], true, true);
    }

    /**
     * 获取标签列表
     * @param array $tag
     * @return array
     */
    public static function getTagsList($tag)
    {
        $condition = empty($tag['condition']) ? '' : $tag['condition'];
        $row = empty($tag['row']) ? 10 : (int) $tag['row'];
        $orderby = empty($tag['orderby']) ? 'nums' : $tag['orderby'];
        $orderway = empty($tag['orderway']) ? 'desc' : strtolower($tag['orderway']);
        $limit = empty($tag['limit']) ? $row : $tag['limit'];
        $cache = !isset($tag['cache']) ? true : (int) $tag['cache'];
        $orderway = in_array($orderway, ['asc', 'desc']) ? $orderway : 'desc';

        $where = [];

        $order = $orderby == 'rand' ? 'rand()' : (in_array($orderby, ['name', 'nums', 'id', 'createtime', 'updatetime']) ? "{$orderby} {$orderway}" : "nums {$orderway}");

        $list = self::where($where)
                ->where($condition)
                ->order($order)
                ->limit($limit)
                ->cache($cache)
                ->select();
        foreach ($list as $k => $v)
        {
            $v['textlink'] = '<a href="' . $v['url'] . '">' . $v['name'] . '</a>';
        }
        return $list;
    }

}
