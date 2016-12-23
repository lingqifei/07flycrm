<?php	 
class FinFlowRecord extends Action{	
	private $cacheDir='';//缓存目录
	public function __construct() {
		_instance('Action/Auth');
	}	
	
	public function fin_flow_record(){
		$currentPage = $this->_REQUEST("pageNum");//第几页
		$numPerPage  = $this->_REQUEST("numPerPage");//每页多少条
		$currentPage = empty($currentPage)?1:$currentPage;
		$numPerPage  = empty($numPerPage)?$GLOBALS["pageSize"]:$numPerPage;
		$countSql    = 'select id from fin_flow_record';
		$totalCount  = $this->C($this->cacheDir)->countRecords($countSql);	//计算记录数
		$totalSql	 = 'select sum(paymoney) as payTotal,sum(recemoney) as receTotal from fin_flow_record';
		$totalRs	 = $this->C($this->cacheDir)->findOne($totalSql);
		$beginRecord = ($currentPage-1)*$numPerPage;
		$sql		 = "select * from fin_flow_record  order by id desc limit $beginRecord,$numPerPage";	
		$list		 = $this->C($this->cacheDir)->findAll($sql);
		if(is_array($list)){
			foreach($list as $key=>$row){
				$list[$key]["blankaccount"] = $this->L("FinBankAccount")->fin_bank_accoun_get_name($row['blankID']);
				$list[$key]["username"] = $this->L("User")->user_get_name($row['create_userID']);
			}
		}
		$assignArray = array('list'=>$list,
							'totalMoney'=>$totalRs,
							"numPerPage"=>$numPerPage,"totalCount"=>$totalCount,"currentPage"=>$currentPage
						);	
		return $assignArray;
	}
	//显示流水财务
	public function fin_flow_record_show(){
			$list	 = $this->fin_flow_record();
			$smarty  = $this->setSmarty();
			$smarty->assign($list);//框架变量注入同样适用于smarty的assign方法
			$smarty->display('fin_flow_record/fin_flow_record_show.html');	
	}		
	
	//流水财务增加函数
	public function fin_flow_record_add($type='rece',$money=100,$blankID=1,$order='123456'){
		$sql="select balance from fin_flow_record where blankID='$blankID' order by id desc";
		$one=$this->C($this->cacheDir)->findOne($sql);
		if($type=="pay"){//支出
			$balance=$one["balance"]-$money;
			$usql="insert into fin_flow_record(blankID,paymoney,balance,adt,create_userID) 
								values('$blankID','$money','$balance','".NOWTIME."','".SYS_USER_ID."');";							
		}elseif($type=="rece"){
			$balance=$one["balance"]+$money;
			$usql="insert into fin_flow_record(blankID,recemoney,balance,adt,create_userID) 
								values('$blankID','$money','$balance','".NOWTIME."','".SYS_USER_ID."');";		
		}
		if($this->C($this->cacheDir)->update($usql)>0){
			return true;
		}else{
			return false;
		}
	}
	//删除流水财务
	public function fin_flow_record_del(){
		$id=$this->_REQUEST("id");
		$sql="delete from fin_flow_record where id='$id'";
		$this->C($this->cacheDir)->update($sql);	
		$this->L("Common")->ajax_json_success("操作成功","1","/FinFlowRecord/fin_flow_record_show/");	
	}	
	
		
}//
?>