<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>TO-DO CI4 example</title>
</head>

<body>
    <div class="container">
        <h3>List</h3>
        <?php foreach ($todos as $item): ?>
            <div class="row">
                <div class="col-1"><?= (int)$item['id'] ?></div>
                <div class="col-1"><input type="checkbox" disabled <?= $item['is_done'] ? 'checked' : '' ?>></div>
                <div class="col"><?= esc($item['title'] ?? '') ?></div>
            </div>
        <?php endforeach; ?>

        <h3>Create a new item</h3>

        <?= session()->getFlashdata('error') ?>
        <?= service('validation')->listErrors() ?>

        <form method="get" action="addTodo">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>