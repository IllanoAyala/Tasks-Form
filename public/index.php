<?php 
    if (isset($_POST['bntEnviar'])){
        include_once('config.php');

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
            
        $create_tasks = mysqli_query($conexao, "INSERT INTO tarefa(Nome, Descricao, DataIni, DataFim, Estado) VALUES('$nome', '$descricao', '$dataInicio', '$dataFim', 0)");

        header("Location: {$_SERVER['REQUEST_URI']}");            
    }
    
    if (isset($_POST['bntConcluir'])){
        include_once('config.php');
        
        if(isset($_POST['ckBox'])){
            $checkboxs = $_POST['ckBox'];            

            if ($checkboxs !== null){         
                for($i = 0; $i < count($checkboxs); $i++){
                    mysqli_query($conexao, "UPDATE tarefa SET Estado = '1' WHERE idTarefa = $checkboxs[$i];");
                }
            }
        }
    }

    if (isset($_GET['deletar'])){
        include_once('config.php');
        
        $id = filter_var($_GET['deletar'], FILTER_SANITIZE_NUMBER_INT);

        mysqli_query($conexao, "DELETE FROM tarefa WHERE idTarefa = $id;");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link rel="stylesheet" type="text/css" href="..\style\style.css">
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
                    <textarea name="descricao"cols="62" rows="7" placeholder="Descrição da Tarefa"></textarea><br>
                    <label>Data de Início:</label><br>
                    <input type="date" name="dataInicio" required><br>
                    <label>Data de Fim:</label><br>
                    <input type="date" name="dataFim" required>
                    <input type="submit" name="bntEnviar" id="bntEnviar">                  
                </form>
            </fieldset>
        </div>
        <div class="tasks">
            <fieldset>
                <legend>Tarefas</legend>
                <form method="POST" action="index.php">
                    <?php
                        include_once('config.php');

                        $query = "SELECT * FROM tarefa";
                        $tasks = $conexao->query($query);

                        if ($tasks->num_rows >= 0){
                            while ($row = $tasks->fetch_assoc()) {
                                $dataInicial = new DateTime($row['DataIni']);
                                $dataFinal = new DateTime($row['DataFim']);
                                $concluida = $row['Estado'];
                                $id = $row['idTarefa'];

                                $diferenca = date_diff($dataInicial, $dataFinal);
                                
                                ?>
                                <fieldset id="fieldset_tasks">                                   
                                    <input type="checkbox" name="ckBox[]" id="checkbox" value="<?php echo $row['idTarefa'];?>" <?php if ($concluida == 1) echo "checked disabled";?>>                        
                                    <label for="box" id="tasks_text"><?php echo $row['Nome'];?></label><br>              
                                    <label id="tasks_description">Descrição: <?php echo $row['Descricao'];?></label><br>
                                    <label id="tasks_duration">Duração: <?php echo $diferenca->format('%a dias.');?></label><br>
                                    <?php 
                                        if($concluida == 1){
                                            echo "<h6 id='tasks_state'>[Concluída]</h6> <a href='index.php?deletar=$id' id='tasks_delete'><img src='..\style\img\lixeira.png' id='icon'></a>";               
                                        }
                                        else{
                                            echo "<h6 id='tasks_state2'>[Em Andamento]</h6>";
                                        }
                                    ?>
                                </fieldset>
                                <?php                           
                            }                           
                        }

                        $conexao->close();
                    ?>
                    <input type="submit" name="bntConcluir" id="bntConcluir" value="Concluir">
                </form>
            </fieldset>
        </div>
        <h6 id="by">Feito por:<a href="www.google.com" target="_blank">Illano Ayala</a></h6>
    </div>
</body>
</html>
