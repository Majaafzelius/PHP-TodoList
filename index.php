<?php
    $page_title = "Startsida";
    include('includes/header.php');
    $task = new Todo();
    

?>
<main>
    <h2>Majas Att göra-lista</h2>
    <h3>Lägg till ny sak att göra</h3>
    <form method='POST' id='in'>
        <label for="todo"><i>Att göra</i></label><br>
        <input type="text" id='todo' name='todo'><br>
        <?php
        $to_do = isset($_POST['todo']) ? $_POST['todo'] : ''; 
        if ($task->checklen($to_do) == false) {
            echo 'För få bokstäver';
        } 
        ?><br><br>
        <label for="name"><i>Vem?</i></label><br>
        <input type="text" id='name' name='name'><br><br>
        <label for="date"><i>Datum</i></label><br>
        <input type="date" id='date' name='date'><br><br>
        <label for="other">Övrig information</label><br>
        <textarea id='other' rows='4' name='other'></textarea><br><br>

        
        <button type='submit' id='sub'>Lägg till</button>
    </form>
    <h3>Saker att göra:</h3>
    <ul>
        
        <?php 
        
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $date = isset($_POST['date']) ? $_POST['date'] : '';
            $other = isset($_POST['other']) ? $_POST['other'] : '';
            
            $task -> set_values( $to_do, $name, $date, $other);
            if ($task->checklen($to_do)) {
            // $task -> set_values( $_POST['todo'], $_POST['name'], $_POST['date'], $_POST['other']);
                $task->addtodo(); }
            $todos = json_decode(file_get_contents('todos.json'));
            foreach ($todos as $todo): {
                if ($todo->task!=null) {
                    ?>
                <li>
                    <div>
                    <?php 
                        echo '<b>' . $todo->task . '</b><br>'; 
                        echo $todo->name . '<br>';
                        echo $todo->date . '<br>';
                        echo $todo->other . '<br>';
                        ?>
                    </div>
                    <?php
                    $task->done($todo->ID);
                    
                }
                else {
                        skip;
                    }
                    
                }         
                endforeach;?>
            </li> 
        </ul>
        <form action="" method="post" >
            <input type="submit" name="empty" value="Rensa" id='clear'>
        </form>
        <?php
        if (isset($_POST['empty'])) {
            $task->clear();
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit;
            
        }
        ?>
    <article id='foot'><a href="todos.json" id='link'>Länk till JSON</a></article>
    
<?php
    include('includes/footer.php');
?>