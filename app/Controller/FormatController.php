<?php
	class FormatController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_detail(){

			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

		public function submit() {
			if ($this->request->is('post')) {
				if(!empty($this->request->data['Type']['type'])) {
					$type = $this->request->data['Type']['type'];
					$this->set(compact('type'));
				}
			}
			$this->set('title',__('Selection result'));
		}	
	}