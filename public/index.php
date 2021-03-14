<?php

    require "../app/Database.php";
    
    $database = new App\Database();

    $message = [];

    if (!empty($_POST))
    {
        // Hydrate all data coming from a user even though we are not doing it
        
        // CREATING A TASK
        if ($_POST['action'] ==  'create')
        {
            try {
                $database->create("tasks", $_POST);
                $message['type'] = 'success';
                $message['text'] = "Task <strong>{$_POST['name']}</strong> created successfully!";
            }
            catch (PDOException $e) {
                $message['type'] = 'danger';
                $message['text'] = $e->getMessage();
            }
        }

        // DELETING A TASK
        if ($_POST['action'] == 'delete')
        {
            try {
                $database->delete("tasks", $_POST['id']);
                $message['type'] = 'info';
                $message['text'] = "Task <strong>{$_POST['name']}</strong> removed successfully!";
            }
            catch (PDOException $e) {
                $message['type'] = 'danger';
                $message['text'] = $e->getMessage();
            }
        }
        
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Todo</title>
  </head>
  <body class="container">

    <h1>Todo</h1>

    <hr />

    <?php

        if (array_key_exists('text', $message))
            echo 
            "
            <div class='alert alert-{$message['type']}' role='alert'>
                {$message['text']}
            </div>
            "
    ?>

    <form action="index.php" method="POST">
        <div class="mb-3">
            <input type="hidden" name="action" value="create" />
            <label for="name" class="form-label">Task Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name of the task">
        </div>
        <div class="mb-3">
            <input type="checkbox" class="form-check-input" name="is_completed" value="true">
            <label class="form-check-label" for="is_completed">Completed</label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Completed</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 

                $tasks = $database->query('tasks');

                foreach ($tasks as $task) {
                    echo "
                        <tr>
                            <td>{$task['id']}</td>
                            <td>{$task['name']}</td>
                            <td>
                    ";
                    
                    /*if ($task['is_completed'])
                        echo('Yes');
                    else
                        echo('No');*/
                    
                    echo $task['is_completed'] ? 'Yes' : 'No';

                    echo "
                            </td>
                            <td>
                                <form action='index.php' method='POST'>
                                    <input type='hidden' name='action' value='delete' />
                                    <a href='/edit.php?id={$task['id']}' class='btn btn-outline-primary'>
                                        Edit
                                    </a>
                                    <button type='submit' class='btn btn-danger'>
                                        Delete
                                    </button>
                                    <input type='hidden' name='id' value='{$task['id']}' />
                                    <input type='hidden' name='name' value='{$task['name']}' />
                                </form>
                            </td>
                        </td>
                    ";
                }
            ?>
        </tbody>
    </table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
  </body>
</html>