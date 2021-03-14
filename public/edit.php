<?php
    $database_path = "/home/anderson/todo-php-react/database/database.sqlite";            
    $database = new PDO("sqlite:{$database_path}");

    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $message = [];

    // Updating
    if ($_POST['action'] == 'update')
    {
        try {
            $_POST['is_completed'] = array_key_exists('is_completed', $_POST);

            $query = $database->prepare("
                UPDATE tasks 
                SET name = :name, is_completed = :is_completed
                WHERE id = :id
            ");
            
            $query->execute([
                ':id'           => $_GET['id'],
                ':name'         => $_POST['name'],
                ':is_completed' => $_POST['is_completed']
            ]);

            $message['type'] = 'success';
            $message['text'] = "Task <strong>{$_POST['name']}</strong> updated successfully!";
        }
        catch (PDOException $e) {
            $message['type'] = 'danger';
            $message['text'] = $e->getMessage();
        }
    }

    // Getting task from the database
    try {
        $query = $database->query("SELECT * FROM tasks WHERE id = {$_GET['id']}");
        $task = $query->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        $message['type'] = 'danger';
        $message['text'] = $e->getMessage();
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

    <title>Todo - Edit Task</title>
  </head>
  <body class="container">
    <h1>
        Todo - Edit Task #<?php echo $_GET['id'] ?>: <?php echo $task['name'] ?>
    </h1>
    <hr />
    <a href="/" class='btn btn-outline-primary'>
        Back
    </a>
    <br /><br />
    <?php 
        var_dump($message);
        if (array_key_exists('text', $message))
            echo 
            "
            <div class='alert alert-{$message['type']}' role='alert'>
                {$message['text']}
            </div>
            "
    ?>
    <form action="/edit.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <div class="mb-3">
            <input type="hidden" name="action" value="update" />
            <label for="name" class="form-label">Task Name</label>
            <input value="<?php echo $task['name'] ?>" type="text" name="name" class="form-control" placeholder="Enter name of the task">
        </div>
        <div class="mb-3">
            <?php 
                echo $task['is_completed'] 
                    ? '<input checked type="checkbox" class="form-check-input" name="is_completed" value="true">'
                    : '<input type="checkbox" class="form-check-input" name="is_completed" value="true">';
            ?>
            <label class="form-check-label" for="is_completed">Completed</label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
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