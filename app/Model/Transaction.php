<?php
	class Transaction extends AppModel {
        var $belongsTo = 'Member';
		var $hasMany = array('TransactionItem' => array(
									'conditions' => array('TransactionItem.valid' => 1)
								)
							);
	}