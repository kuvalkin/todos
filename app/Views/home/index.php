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
        <?= session()->getFlashdata('error') ?>
        <!-- todo display pretty errors -->
        <?php if (is_array(session()->getFlashdata('errors'))): ?>
            <?php foreach (session()->getFlashdata('errors') as $key => $value): ?>
                <?= esc($key) . ': ' . esc($value) ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>List</h3>
        <?php foreach ($todos as $item) : ?>
            <div v-scope="ToDoItem({id: <?= (int)$item['id'] ?>, isDone: <?= $item['is_done'] ? 'true' : 'false' ?>, title: '<?= esc($item['title']) ?>'})"></div>
        <?php endforeach; ?>

        <h3>Create a new item</h3>
        <?= service('validation')->listErrors() ?>

        <form method="post" action="addTodo">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- <script src="https://unpkg.com/petite-vue@0.2.2/dist/petite-vue.iife.js" defer init></script> -->

    <script type="module">
        import {
            createApp
        } from 'https://unpkg.com/petite-vue?module';

        function ToDoItem(props) {
            return {
                $template: '#todo-item-template',

                id: props.id,
                isDone: props.isDone,
                title: props.title,

                isLoading: false,
                
                async checkIsDone() {
                    if (this.isLoading) {
                        return;
                    }
                    this.isLoading = true;

                    const response = await fetch('/api/v1/todos', {
                        method: 'PATCH',
                        body: JSON.stringify({
                            isDone: !this.isDone,
                        }),
                    });

                    if (response.ok) {
                        this.isDone = !this.isDone;
                    } else {
                        const json = await response.json();
                        console.log(json);
                        // alert(json.messages);
                    }

                    this.isLoading = false;
                }
            };
        }

        createApp({
            ToDoItem
        }).mount();
    </script>

    <template id="todo-item-template">
        <div class="row">
            <div class="col-1">{{id}}</div>
            <div class="col-1">
                <input type="checkbox" :checked="isDone" @click="checkIsDone" :disabled="isLoading">
            </div>
            <div class="col">{{title}}</div>
        </div>
    </template>
</body>

</html>