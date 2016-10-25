<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/30
 * Time: 15:59
 */
class ShellAction extends Action
{
    public function index()
    {

        //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
        ignore_user_abort();
        //   执行时间
        set_time_limit(0);
        // 每隔1秒钟运行
//        $interval=1;
        //实例化
        $objCustomerSeo = M('CustomerSeo');
        $objCustomerSeoRecord = M('CustomerSeoRecord');
        //所有关键字数组
        $arrCustomerSeo = $objCustomerSeo->where('status=1')->select();
        $user_data = array();
        foreach($arrCustomerSeo as $k=>$v){
            $seo_data = send_seo($v['world'],$v['url']);
            if($seo_data['paixu']!=0){
                //记录
               $data['world_id'] = $v['id'];
               $data['inquiry_date'] = date('Y-m-d H-s-i');
               $data['ranking'] = $seo_data['paixu'];
               $data['url'] = $v['url'];
               $data['world'] = $v['world'];
               $data['customer_id'] = $v['customer_id'];
               $objCustomerSeoRecord->add($data);
                //字段修改
                $Cdata['max_lines'] = $v['max_lines']*1+1;
                $Cdata['ranking'] = $seo_data['paixu'];
                if($v['surplus_lines']>0){
                    $Cdata['surplus_lines'] = $v['surplus_lines']*1-1;
                }
                if(date('d')==1){
                    $Cdata['month_lines']=1;
                }
                $Cdata['month_lines'] = $v['month_lines']*1+1;
                if(!$v['first_lines']){
                    $Cdata['first_lines'] = date('Y-m-d H-s-i');
                }
                //如果数据存储成功则记录价格
                if($objCustomerSeo->where('id='.$v['id'])->save($Cdata)){
                    //记录当前使用了的价格
                    $user_data[$v['customer_id']]['univalent_days'] += $v['univalent_days'];
                }
            };
        }
        //资金修改 start
        $objCustomer = M('Customer');
        $arrCustomer = $objCustomer->select();
        foreach($arrCustomer as $k=>$v){
            $arrCustomer_new[$v['customer_id']] = $v;
        }
        foreach($user_data as $k=>$v){
            $arrCustomer_new[$k]['balance'] =  $arrCustomer_new[$k]['balance']-$v['univalent_days'];
            $arrCustomer_new[$k]['Consumption'] =$arrCustomer_new[$k]['Consumption']+$v['univalent_days'];
        }
        $objFinance = M('Finance');
        foreach($arrCustomer_new as $k=>$v){
            if($objCustomer->save($v)){
            //资金记录
                $dataFinance['creator_role_id'] = $_SESSION['role_id'];
                $dataFinance['name'] ='seo';
                $dataFinance['check_role_id'] = $_SESSION['role_id'];
                $dataFinance['create_time'] = time();
                $dataFinance['check_result'] = 1;
                $dataFinance['description'] = 'seo搜索资金记录';
                $dataFinance['income_or_expenses'] = -1;
                $dataFinance['money'] = $user_data[$v['customer_id']]['univalent_days'];
                $dataFinance['plan_money'] = $user_data[$v['customer_id']]['univalent_days'];
                $objFinance->add($dataFinance);
            }
        }
        //资金修改 end
        $this->display();
    }
}