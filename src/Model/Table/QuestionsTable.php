<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoryTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('questions');
        $this->primaryKey('id');
    	$this->hasMany("Answer", 'question_id');
        // $this->belongsTo('Category', ['foreignKey' => 'category_id']);
    }

}