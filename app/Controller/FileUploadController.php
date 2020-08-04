<?php

class FileUploadController extends AppController {	
	public function index() {
		$this->set('title', __('File Upload Answer'));
		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}

	public function upload() {
		if ($this->request->is('post')) {
			if(!empty($this->request->data['FileUpload']['file'])) {
				$file = $this->request->data['FileUpload']['file'];
				$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
				$now = date('Y-m-d h:i:s');
				$insert = [];

				if($extension == 'csv') {
					$firstRow = true;
					ini_set('auto_detect_line_endings', TRUE);

					$delimiter = $this->detectCSVFileDelimiter($file['tmp_name']);
					$handle = fopen($file['tmp_name'], "r");
					while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
						if(!$firstRow) {
							if(isset($data[0]) && isset($data[1])) {
								$insert[] = [
									'FileUpload'=> [
										'name'=>$data[0],
										'email'=>$data[1], 
										'created'=>$now, 
										'modified'=>$now
									]
								];
							}
						}
						$firstRow = false;
					};

					if($this->FileUpload->saveall($insert)) {
						$this->setSuccess('Success upload file!');
					} else {
						$this->setError('Failed in database transaction!');
					}
				} else {
					$this->setError('File extension must be csv!');
				}
			}
		} else {
			$this->setError('No file to upload!');
		}
		$this->redirect('/FileUpload');
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