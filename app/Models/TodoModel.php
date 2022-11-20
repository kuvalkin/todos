<?php

namespace App\Models;

use CodeIgniter\Model;

class TodoModel extends Model
{
    protected $table = 'todos';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'is_done'];

    protected $validationRules = [
        'title'     => 'required|max_length[512]|alpha_numeric_punct',
    ];

    public function exists($id): bool
    {
        //todo optimize query
        return !!$this->find($id);
    }
}