<?php

namespace app\qiaomao\model;
use think\Model;
use think\Db;

class Stylist extends Model
{
    protected $tb_stylist = 'stylist';
    protected $tb_stylist_schedule = 'stylist_schedule';
    
    /**
     * 获取造型师所有可用时间段
     *
     * @param string $stylist_id
     *            造型师的id
     * @param string $start_time
     * @param bool $end_time
     * @param bool $type
     * @return array
     */
    
    public function getTime($stylist_id, $start_time = '1970-01-01 00:00:00', $end_time = '9999-12-31 23:59:59', $type = false, $page = 1, $page_size = 24)
    {
        $page_size = $page_size > 200 ? 200 : intval($page_size);
        $special_1 = [];
        $special_2 = [];
        $special_3 = [];
        $temp = true;
        $start_time = empty($start_time) ? '1970-01-01 00:00:00' : $start_time;
        $end_time = empty($end_time) ? '9999-12-31 23:59:59' : $end_time;
        $conds = [
            'stylist_id' => $stylist_id,
            'type' => ['>', 0],
            'start_time' => ['between', [$start_time, $end_time]],
            'end_time' => ['between', [$start_time, $end_time]]
        ];
        if (($type && $type == 1) || ($type && $type == 2)) {
            $conds['type'] = $type;
        }
    
        if (Db::name($this->tb_stylist)->where(['id'=>$stylist_id])->find()) {
            $special_1 = Db::name($this->tb_stylist_schedule)->where([
				'start_time' => ['<', $start_time],
				'end_time' => ['between', [$start_time, $end_time]],
				'type' => $type ? $type : ['in', ['1', '2']],
				'stylist_id' => $stylist_id
			])->page($page, $page_size)->select();
			$special_2 = Db::name($this->tb_stylist_schedule)->where([
				'start_time' => ['between', [$start_time, $end_time]],
				'end_time' => ['>', $end_time],
				'type' => $type ? $type : ['in', ['1', '2']],
				'stylist_id' => $stylist_id
			])->page($page, $page_size)->select();
			$special_3 = Db::name($this->tb_stylist_schedule)->where([
				'start_time' => ['<', $start_time],
				'end_time' => ['>', $end_time],
				'type' => $type ? $type : ['in', ['1', '2']],
				'stylist_id' => $stylist_id
			])->page($page, $page_size)->select();
    
            // 获取造型师有效时间段
            $res = Db::name($this->tb_stylist_schedule)->where($conds)->page($page, $page_size)->select();
            foreach ($special_1 as $v) {
                array_push($res, ['start_time' => $start_time,
                    'end_time' => $v['end_time'],
                    'type' => $v['type']]);
            }
            foreach ($special_2 as $v) {
                array_push($res, ['start_time' => $v['start_time'],
                    'end_time' => $end_time,
                    'type' => $v['type']]);
            }
            foreach ($special_3 as $v) {
                array_push($res, ['start_time' => $start_time,
                    'end_time' => $end_time,
                    'type' => $v['type']]);
            }
            if (empty ($res)) {
                return [
                    'status' => 'success',
                    'data' => []
                ];
            }
    
            $data = [];
            // 今日的时间戳
            if ($res) {
                foreach ($res as $value) {
                    if ($value['start_time'] == $value['end_time']) {
                        continue;
                    }
                    $data [] = [
                        'start_time' => $value ['start_time'],
                        'end_time' => $value ['end_time'],
                        'type' => $value['type']
                    ];
    
                }
            }
    
            // 返回空闲的时间段
            return [
                'query' => [
                    'start_stime' => $start_time ?: '1970-01-01 00:00:00',
                    'end_stime' => $end_time ?: date('Y-m-d H:i:s'),
                    'type' => $type ?: '',
                    'page' => $page,
                    'page_size' => $page_size
                ],
                'status' => 'success',
                'data' => $data
            ];
        }
    
        return [
            'status' => 'error',
            'msg' => '造型师不存在'
        ];
    }
    
    public function getTimeNew($stylist, $start_time, $end_time, $type = false, $version = '2.0')
    {
    
        if ((strtotime($end_time) - strtotime($start_time)) > 60 * 60 * 24) {
            return [
                'status' => 'error',
                'msg' => '时间跨度不能大于24小时',
                'data' => ''
            ];
        }
    
    if (!Db::name($this->tb_stylist)->where(['id'=>$stylist])->find()) {
			return [
				'status' => 'error',
				'msg' => '造型师不存在'
			];
		}
    
       $stylist_schedule = Db::name('stylist_schedule')
		    ->where([
				'stylist_id' => $stylist,
				'start_time' => ['between', [date('Y-m-d', strtotime($start_time)) . ' 00:00:00', date('Y-m-d', strtotime($start_time)) . ' 23:59:59']]
			])
			->select();
    
        if ($stylist_schedule) {
            return [
                'status' => 'success',
                'data' => []
            ];
        }
    
        //获取是星期几和小时
        $week = '';
        $start_time_w = date('w', strtotime($start_time));
        $end_time_w = date('w', strtotime($end_time));
        $start_time_H = date('H', strtotime($start_time));
        $end_time_H = date('H', strtotime($end_time));
    
        if ($start_time_w == $end_time_w) {
            if ($start_time_w >= 1 && $start_time_w <= 5) {
                $week = 'weekday';
            } else {
                $week = 'weekend';
            }
            $stylist_ser = Db::name('stylist_ser')->where(['stylist_id' => $stylist])->find();
           
            $schedule = json_decode($stylist_ser['free_time'], true);
    
            if (empty($schedule)) {
                $free_time = range(6, 22, 1);
            } else {
                $free_time = $schedule[$week];
            }
    
            $all_time = range(0, 23, 1);
            $busy_time = array_diff($all_time, $free_time);
            sort($busy_time);
            $ask_time = range($start_time_H, $end_time_H, 1);
    
            if ($type == 1) {
                $require_time = array_intersect($ask_time, $free_time);
            } else {
                $require_time = array_intersect($ask_time, $busy_time);
            }
    
            sort($require_time);
            $data = [];
            foreach ($require_time as $key => $val) {
                $data[$key]['start_time'] = date('Y-m-d', strtotime($start_time)) . ' ' . $val . ':00:00';
                $data[$key]['end_time'] = date('Y-m-d', strtotime($start_time)) . ' ' . ($val + 1) . ':00:00';
                $data[$key]['type'] = $type;
            }
    
        } else {
            if ($start_time_w >= 1 && $start_time_w <= 5) {
                $week = 'weekday_weekend';
            } else {
                $week = 'weekend_weekday';
            }
    
            $stylist_ser = Db::name('stylist_ser')->where(['stylist_id' => $stylist])->find();
            $schedule = json_decode($stylist_ser['free_time'], true);
    
            $require = explode('_', $week);
    
            if (empty($schedule)) {
                $s1_free = [];
                $s2_free = [];
            } else {
                $s1_free = $schedule[$require[0]];
                $s2_free = $schedule[$require[1]];
            }
    
            $all_time = range(0, 23, 1);
            $s1_busy = array_diff($all_time, $s1_free);
            $s2_busy = array_diff($all_time, $s2_free);
            sort($s1_busy);
            sort($s2_busy);
    
            $ask_time_1 = range($start_time_H, 23, 1);
            $ask_time_2 = range(0, $end_time_H, 1);
    
            if ($type == 1) {
                $require_time_1 = array_intersect($ask_time_1, $s1_free);
                $require_time_2 = array_intersect($ask_time_2, $s2_free);
            } else {
                $require_time_1 = array_intersect($ask_time_1, $s1_busy);
                $require_time_2 = array_intersect($ask_time_2, $s2_busy);
            }
    
            sort($require_time_1);
            sort($require_time_2);
    
            $data_1 = [];
            $data_2 = [];
            foreach ($require_time_1 as $key => $val) {
                $data_1[$key]['start_time'] = date('Y-m-d', strtotime($start_time)) . ' ' . $val . ':00:00';
                $data_1[$key]['end_time'] = date('Y-m-d', strtotime($start_time)) . ' ' . ($val + 1) . ':00:00';
                $data_1[$key]['type'] = $type;
            }
    
            foreach ($require_time_2 as $key => $val) {
                $data_2[$key]['start_time'] = date('Y-m-d', strtotime($end_time)) . ' ' . $val . ':00:00';
                $data_2[$key]['end_time'] = date('Y-m-d', strtotime($end_time)) . ' ' . ($val + 1) . ':00:00';
                $data_2[$key]['type'] = $type;
            }
    
            $data = array_merge_recursive($data_1, $data_2);
    
        }
    
        return [
            'status' => 'success',
            'data' => $data
        ];
    
    }

}