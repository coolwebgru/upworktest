<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoryTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('category');
        $this->displayField('categoryname');
        $this->primaryKey('id');
    	$this->hasMany("Questions");
    }
}