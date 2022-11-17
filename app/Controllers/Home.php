<?php

namespace App\Controllers;

use App\Models\TodoModel;

class Home extends BaseController
{
    public function index()
    {
        /** @var TodoModel $todoModel */
       $todoModel = model(TodoModel::class);

        return view(
            'home/index',
            [
                'todos' => $todoModel->findAll(20),
            ],
        );
    }
}
