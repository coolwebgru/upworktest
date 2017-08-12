<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AnswerTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('answer');
        $this->primaryKey('id');
        // $this->belongsTo('Questions', ['foreignKey' => 'question_id']);
    }
}