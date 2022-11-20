<?php

namespace App\Controllers;

use App\Libraries\Exceptions\WrongHttpMethodException;
use App\Models\TodoModel;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;

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

        /** @var TodoModel $model */
        $model = model(TodoModel::class);

        $isSuccess = $model->save([
            'title' => $this->request->getPost('title'),
        ]);

        if (!$isSuccess) {
            //todo how to list validation errors natively?
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->back();
    }

    /**
     * This method tries to be RESTful
     */
    public function updateTodo()
    {
        if ($this->request->getMethod() !== 'patch') {
            throw new WrongHttpMethodException();
        }

         /** @var TodoModel $todoModel */
        $todoModel = model(TodoModel::class);

        //todo pass id in uri
        $id = $this->request->getJsonVar('id');

        if (!$todoModel->exists($id)) {
            return $this->failNotFound();
        }

        $json = $this->request->getJSON(true);
        $toUpdate = [];
        if (array_key_exists('isDone', $json)) {
            $toUpdate['is_done'] = $json['isDone'];
        }
        if (array_key_exists('title', $json)) {
            $toUpdate['title'] = $json['title'];
        }

        //todo debug while the records updated all at once
        $isSuccess = $todoModel->update(
            $id,
            $toUpdate,
        );

        if (!$isSuccess) {
            return $this->failValidationErrors($todoModel->errors());
        }

        //todo return new model data?
        return $this->respondUpdated();
    }
}
