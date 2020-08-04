<?php
	class MigrationController extends AppController{
		
		public function q1(){			
		}
		
		public function q1_instruction(){
			$this->setFlash('Question: Migration of data to multiple DB table');				
		}

		public function upload() {
			if ($this->request->is('post')) {
				if(!empty($this->request->data['FileUpload']['file'])) {
					App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel.php'));

					$file = $this->request->data['FileUpload']['file'];
					$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
					$now = date('Y-m-d h:i:s');
					$insert = [];
					$allowedExt = ['xls', 'xlsx', 'csv'];

					if(in_array($extension, $allowedExt)) {
						$tmp_name = $file['tmp_name'];
						$excelReader = PHPExcel_IOFactory::createReaderForFile($tmp_name);
						$excelObj = $excelReader->load($tmp_name);
						$worksheet = $excelObj->getSheet(0);
						$lastRow = $worksheet->getHighestRow();

						for ($row = 2; $row <= $lastRow; $row++) {
							$date = PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell('A'.$row)->getValue(), 'YYYY-MM-DD');
							$year = (int)date('Y',strtotime($date));
							$month = (int)date('m',strtotime($date));

							$ref_no =  $worksheet->getCell('B'.$row)->getValue();
							$member_name = $worksheet->getCell('C'.$row)->getValue();

							$member_no = $worksheet->getCell('D'.$row)->getValue();
							$member_no = (explode(" ",$member_no));
							if(count($member_no) == 2) {
								$type = $member_no[0];
								$no = preg_replace("/[^0-9]/", "", $member_no[1]);
							} else {
								$type = '';
								$no = '';
							}

							$member_paytype = $worksheet->getCell('E'.$row)->getValue();
							$member_company = $worksheet->getCell('F'.$row)->getValue();
							$payment_method = $worksheet->getCell('G'.$row)->getValue();
							$batch_no = $worksheet->getCell('H'.$row)->getValue();
							$receipt_no = $worksheet->getCell('I'.$row)->getValue();
							$cheque_no = $worksheet->getCell('J'.$row)->getValue();
							$cheque_no = $worksheet->getCell('J'.$row)->getValue();
							$description = $worksheet->getCell('K'.$row)->getValue();
							$renewal_year = $worksheet->getCell('L'.$row)->getValue();
							$subtotal = $worksheet->getCell('M'.$row)->getValue();
							$tax = $worksheet->getCell('N'.$row)->getValue();
							$total = $worksheet->getCell('O'.$row)->getValue();

							if($member_name!= null) {
								$insert[] = [
									'Member'=> [
										'type'=>$type,
										'no'=>$no,
										'name'=>$member_name,
										'company'=>$member_company,
										'valid'=>1,
										'created'=>$now,
										'modified'=>$now
									],
									'Transaction'=> [
										[
											'member_name'=>$member_name,
											'member_paytype'=>$member_paytype,
											'member_company'=>$member_company,
											'date'=>$date,
											'year'=>$year,
											'month'=>$month,
											'ref_no'=>$ref_no,
											'receipt_no'=>$receipt_no,
											'payment_method'=>$payment_method,
											'batch_no'=>$batch_no,
											'cheque_no'=>$cheque_no,
											'payment_type'=>$description,
											'renewal_year'=>$renewal_year,
											'remarks'=>null,
											'subtotal'=>$subtotal,
											'tax'=>$tax,
											'total'=>$total,
											'valid'=>1,
											'created'=>$now,
											'modified'=>$now,
											'TransactionItem'=> [
												[
													'description'=> 'Being Payment for : \r\n'.$description.' : '.$renewal_year,
													'quantity'=>1,
													'unit_price'=>$subtotal,
													'uom'=>null,
													'sum'=>$subtotal,
													'valid'=>1,
													'created'=>$now,
													'modified'=>$now,
													'table'=>'Member',
													'table_id'=>1
												]
											]
										]
									]
								];								
							}
						}

						if(count($insert) > 0) {
							$this->loadModel('Member');
							//debug($insert);exit;
							if( $this->Member->saveMany($insert, array('deep' => true))) {
								$this->setSuccess('Success upload file!');
							} else {
								$this->setError('Failed in database transaction!');
							}
						} else {
							$this->setError('No data to import!');
						}
					}  else {
						$this->setError('Please upload an excel file!');
					}
				} else {
					$this->setError('No file to upload!');
				}
			}
			$this->redirect('/Migration/q1');
		}

		public static function detectCSVFileDelimiter($csvFile) { 
			$delimiters = array( ',' => 0, ';' => 0, "\t" => 0, '|' => 0, ); 
			$firstLine = ''; 
			$handle = fopen($csvFile, 'r'); 
	
			if ($handle) { 
				$firstLine = fgets($handle); 
				fclose($handle); 
			} 
	
			if ($firstLine) { 
				foreach ($delimiters as $delimiter => &$count) { 
					$count = count(str_getcsv($firstLine, $delimiter)); 
				} 
	
				return array_search(max($delimiters), $delimiters); 
			} else { 
				return key($delimiters); 
			} 
		}
	}