<?php 

    $database_path = "/home/anderson/todo-php-react/database/database.sqlite";            
    $database = new PDO("sqlite:{$database_path}");

    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST))
    {
        try {
            $query = $database->prepare('
                INSERT INTO tasks values (
                    :name, 
                    :is_completed
                )
            ');

            $query->bindParam(':name', $_POST['name']);
            $query->bindParam(':is_completed', $_POST['is_completed']);

            $query->execute();

            //echo ("Task {$_POST['name']} saved successfully!");
        }
        catch (PDOException $e) {
            echo($e->getMessage());
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

    <title>Hello, world!</title>
  </head>
  <body class="container">

    <form action="index.php" method="POST">
        <div class="mb-3">
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
                <th scope="col">Name</th>
                <th scope="col">Completed</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $tasks = $database->query('
                    SELECT * FROM tasks
                ');

                foreach ($tasks as $task) {
                    echo "
                        <tr>
                            <td>{$task['name']}</td>
                            <td>
                    ";
                    
                    /*if ($task['is_completed'])
                        echo('Yes');
                    else
                        echo('No');*/
                    
                    echo($task['is_completed'] == 'true' ? 'Yes' : 'No');

                    echo "
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