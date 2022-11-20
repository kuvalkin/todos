<?php

namespace App\Controllers;

use App\Libraries\Exceptions\WrongHttpMethodException;
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

    public function addTodo()
    {
        if ($this->request->getMethod() !== 'post') {
            throw new WrongHttpMethodException();
        }

        if (!$this->validate(['title' => 'required|max_length[512]|alpha_numeric_punct'])) {
            return redirect()->back()->withInput();
        }

        model(TodoModel::class)->save([
            'title' => $this->request->getPost('title'),
        ]);

        return redirect()->back();
    }
}
