<?php 
    if (isset($_POST['submit'])){
            include_once('config.php');

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
            
        $create_tasks = mysqli_query($conexao, "INSERT INTO tarefa(Nome, Descricao, DataIni, DataFim) VALUES('$nome', '$descricao', '$dataInicio', '$dataFim')");

        if ($create_tasks) {
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
        }      
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
    <div>
        <div class="create-tasks">
            <h1>Lista de Tarefas</h1>
            <fieldset>
                <legend>Criar Tarefas</legend>
                <form method="POST" action="index.php">
                    <label>Nome da Tarefa:</label><br>
                    <input type="text" name="nome" placeholder="Nova Tarefa" required><br>
                    <label>Descrição da Tarefa: </label><br>
                    <textarea name="descricao"cols="60" rows="7" placeholder="Descrição da Tarefa"></textarea><br>
                    <label>Data de Início:</label><br>
                    <input type="date" name="dataInicio" required><br>
                    <label>Data de Fim:</label><br>
                    <input type="date" name="dataFim" required>
                    <input type="submit" name="submit" id="submit">
                </form>
            </fieldset>
        </div>
        <div class="tasks">
            <fieldset>
                <legend>Tarefas</legend>
                <?php
                    include_once('config.php');

                    $query = "SELECT * FROM tarefa";
                    $tasks = $conexao->query($query);

                    if ($tasks->num_rows >= 0){
                        while ($row = $tasks->fetch_assoc()) {
                            $dataInicial = new DateTime($row['DataIni']);
                            $dataFinal = new DateTime($row['DataFim']);

                            $diferenca = date_diff($dataInicial, $dataFinal);
                            
                            ?>
                            <input type="checkbox" name="box" id="checkbox">                        
                            <label for="box" id="tasks_text"><?php echo $row['Nome'];?> - </label><br>                 
                            <label id="tasks_description">Descrição: <?php echo $row['Descricao'];?></label><br>
                            <label id="tasks_duration">Duração: <?php echo $diferenca->format('%a dias.');?></label><br><br>
                            <?php                 
                        }
                    }

                    else{
                        
                    }

                    $conexao->close();
                ?>
            </fieldset>
        </div>
        <h6 id="by">Feito por:<a href="www.google.com" target="_blank">Illano Ayala</a></h6>
    </div>
  
</body>
</html>