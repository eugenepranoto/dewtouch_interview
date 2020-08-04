<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;

			// To Do - write your own array in this format
			$c_order = count($orders);
			$order_reports = [];
			for($i=0; $i<$c_order; ++$i) {
				$order_reports[$orders[$i]['Order']['name']] = [];
				$order_detail = $orders[$i]['OrderDetail'];
				$c_order_detail = count($order_detail);
				$order_ingridients = [];

				for($j=0; $j<$c_order_detail; ++$j) {
					$item_portions = null;
					foreach ($portions as $key => $value) {
						if ($value['Item']['id'] == $order_detail[$j]['Item']['id']) {
							$item_portions = $value;
						}
					}
					if(!empty($item_portions)) {
						$qty = $order_detail[$j]['quantity'];
						$item_portion_details = $item_portions['PortionDetail'];
						$c_item_portion_details = count($item_portion_details);
						for($k=0; $k<$c_item_portion_details; ++$k) {
							if(!isset($order_ingridients[$item_portion_details[$k]['Part']['name']])) {
								$order_ingridients[$item_portion_details[$k]['Part']['name']] = $item_portion_details[$k]['value'] * $qty;
							} else {
								$order_ingridients[$item_portion_details[$k]['Part']['name']] += $item_portion_details[$k]['value'] * $qty;
							}
						}
					}
					$order_reports[$orders[$i]['Order']['name']] = $order_ingridients;
				}
			}

			// ...

			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}