<?php
	class RecordController extends AppController{
		
		public function index(){
			ini_set('memory_limit','256M');
			set_time_limit(0);
			$link = Router::url('/Record/retrieve', true); 
			$this->setFlash('Listing Record page too slow, try to optimize it.');
			$this->set('title',__('List Record'));
			$this->set(compact('link'));
		}

		public function retrieve() {
            $this->layout = null;
			$start = $this->request->query('iDisplayStart');
			$length = $this->request->query('iDisplayLength');
			$echo = $this->request->query('sEcho');
			$sortCol = $this->request->query('iSortCol_0') ? 'Record.name' : 'Record.id';
			$sortDirection = $this->request->query('sSortDir_0');

			$total = $this->Record->find('count');
			$get = $this->Record->find('all', array(
					'fields'=>array('Record.id','Record.name'),
					'limit' => $length,
					'offset'=> $start,
					'recursive' => -1,
					'order' => array(
						$sortCol => $sortDirection
					)
				)
			);
			
			$data = [];
			$c_data = count($get);
			for($i=0; $i<$c_data; ++$i) {
				$data[] = [$get[$i]['Record']['id'], $get[$i]['Record']['name']];
			}

			$res = [
				'sEcho'=> $echo,
				'iTotalRecords'=> $total,
				'iTotalDisplayRecords'=> $total,
				'aaData'=> $data
			];

			$this->response->type('json');
            $this->response->body(json_encode($res));
            return $this->response;
		}
		
		
// 		public function update(){
// 			ini_set('memory_limit','256M');
			
// 			$records = array();
// 			for($i=1; $i<= 1000; $i++){
// 				$record = array(
// 					'Record'=>array(
// 						'name'=>"Record $i"
// 					)			
// 				);
				
// 				for($j=1;$j<=rand(4,8);$j++){
// 					@$record['RecordItem'][] = array(
// 						'name'=>"Record Item $j"		
// 					);
// 				}
				
// 				$this->Record->saveAssociated($record);
// 			}
			
			
			
// 		}
	}