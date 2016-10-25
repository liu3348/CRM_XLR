<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/30
 * Time: 11:24
 */
class SeoAction extends Action{
    public function _initialize(){
//        $action = array(
//            'permission'=>array(),
//            'allow'=>array('index','widget_edit','widget_delete','widget_add','calendar','sortcharts')
//        );
//        B('Authenticate', $action);
    }
    /**
     * Created by PhpStorm.
     * rn: Administrator
     * wd: 2016/8/30
     * userUrl: 11:24
     */
    public  function  index(){
        $objSeoSearch = M('SeoSearch');

        $arrSeoSearch = $objSeoSearch->where('user_id='.$_SESSION['role_id'])->order('search_id DESC')->select();
        $this->seo_search = $arrSeoSearch;
        if($_POST['world']&&$_POST['url']){
           $arrSeos =  send_seo($_POST['world'],$_POST['url']);
            echo json_encode($arrSeos);die();
        }
        $this->display();
    }
    public function excelImport(){
        //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
        ignore_user_abort();
        //   执行时间
        set_time_limit(0);

        $m_event = M('event');
        if($_POST['submit']){
            if (isset($_FILES['excel']['size']) && $_FILES['excel']['size'] != null) {
                import('@.ORG.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 20000000;
                $upload->allowExts  = array('xls');
                $dirname = UPLOAD_PATH . date('Ym', time()).'/'.date('d', time()).'/';
                if (!is_dir($dirname) && !mkdir($dirname, 0777, true)) {
                    alert('error', L('ATTACHMENTS TO UPLOAD DIRECTORY CANNOT WRITE'), U('event/index'));
                }
                $upload->savePath = $dirname;
                if(!$upload->upload()) {
                    alert('error', $upload->getErrorMsg(), U('event/index'));
                }else{

                    $info =  $upload->getUploadFileInfo();
                }
            }
            if(is_array($info[0]) && !empty($info[0])){
                $savePath = $dirname . $info[0]['savename'];
            }else{
                alert('error', L('UPLOAD FAILED'), U('event/index'));
            };
            import("ORG.PHPExcel.PHPExcel");
            $PHPExcel = new PHPExcel();
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($savePath)){
                $PHPReader = new PHPExcel_Reader_Excel5();
            }
            $PHPExcel = $PHPReader->load($savePath);
            $currentSheet = $PHPExcel->getSheet(0);
            $allRow = $currentSheet->getHighestRow();
            $message_Row_length = $allRow-2;
            $objSeoSearch = M('SeoSearch');
            for ($currentRow = 3;$currentRow <= $allRow;$currentRow++) {
                $data['name'] = trim($currentSheet->getCell('A'.$currentRow)->getValue());
                $data['url'] = trim($currentSheet->getCell('B'.$currentRow)->getValue());
                $data['user_id'] = $_SESSION['role_id'];
                $data['search_time'] = date('Y-m-d H:i:s');
                if($data['name']!=''&& $data['url']!=''){
                $arrSeo =send_seo($data['name'],$data['url']);
                $data['ranking'] = $arrSeo['paixu'];
                $objSeoSearch->add($data);
                }
            }
            alert('success', L('IMPORT SUCCESS',array($error_message)), U('seo/index'));
        }else{
            $objSeoSearch = M('SeoSearch');
            $arrSeoSearch = $objSeoSearch->where('user_id='.$_SESSION['role_id'])->order('search_id DESC')->select();
            $this->seo_search = $arrSeoSearch;
            $this->display();
        }
    }
}