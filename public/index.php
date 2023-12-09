<?php 
    if (isset($_POST['bntEnviar'])){
        include_once('config.php');

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
            
        $create_tasks = mysqli_query($conexao, "INSERT INTO tarefa(nome, descricao, data_inicio, data_fim, estado) VALUES('$nome', '$descricao', '$dataInicio', '$dataFim', 0)");

        header("Location: {$_SERVER['REQUEST_URI']}");            
    }
    
    if (isset($_POST['bntConcluir'])){
        include_once('config.php');
        
        if(isset($_POST['ckBox'])){
            $checkboxs = $_POST['ckBox'];            

            if ($checkboxs !== null){         
                for($i = 0; $i < count($checkboxs); $i++){
                    mysqli_query($conexao, "UPDATE tarefa SET estado = '1' WHERE id = $checkboxs[$i];");
                }
            }
        }
    }

    if (isset($_GET['deletar'])){
        include_once('config.php');
        
        $id = filter_var($_GET['deletar'], FILTER_SANITIZE_NUMBER_INT);

        mysqli_query($conexao, "DELETE FROM tarefa WHERE id = $id;");
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
            <h1>{ Lista de Tarefas }</h1>
            <fieldset>
                <form method="POST" action="index.php">
                    <div style="padding: 10px; display: flex; flex-direction: column;">
                        <label>Nome da Tarefa:</label>
                        <input type="text" name="nome" placeholder="Nova Tarefa" required>
                        <label>Descrição da Tarefa: </label>
                        <textarea name="descricao"cols="62" rows="7" placeholder="Descrição da Tarefa" style="resize: none;"></textarea>
                        <label>Data de Início:</label>
                        <input type="date" name="dataInicio" required>
                        <label>Data de Fim:</label>
                        <input type="date" name="dataFim" required>
                        <input type="submit" name="bntEnviar" id="bntEnviar">  
                    </div>
                </form>
            </fieldset>
        </div>
        <div class="tasks">
            <fieldset>
                <legend>Tarefas</legend>
                <form method="POST" action="index.php">
                <?php
                    include_once('config.php');

                    $result = $conexao->query("SELECT COUNT(*) as total_tarefas FROM tarefa");
                    $query = "SELECT * FROM tarefa";
                    $tasks = $conexao->query($query);

                    if ($tasks->num_rows > 0) {
                        while ($row = $tasks->fetch_assoc()) {
                            $dataInicial = new DateTime($row['data_inicio']);
                            $dataFinal = new DateTime($row['data_fim']);
                            $concluida = $row['estado'];
                            $id = $row['id'];

                            $diferenca = date_diff($dataInicial, $dataFinal);
                    ?>

                            <fieldset>
                                <input type="checkbox" name="ckBox[]" id="checkbox" value="<?php echo $row['id']; ?>" <?php if ($concluida == 1) echo "checked disabled"; ?>>
                                <label for="box" id="tasks_text"><?php echo $row['nome']; ?></label><br>
                                <label id="tasks_description">Descrição: <?php echo $row['descricao']; ?></label><br>
                                <label id="tasks_duration">Duração: <?php echo $diferenca->format('%a dias.'); ?></label><br>
                                <?php
                                if ($concluida == 1) {
                                    echo "<h6 id='tasks_state'>[Concluída]</h6> <a href='index.php?deletar=$id' id='tasks_delete'><img src='..\style\img\lixeira.png' id='icon'></a>";
                                } else {
                                    echo "<h6 id='tasks_state2'>[Em Andamento]</h6>";
                                }
                                ?>
                            </fieldset>

                    <?php
                        }
                    }

                    if ($result) {
                        $row_count = $result->fetch_assoc()['total_tarefas'];
                        if ($row_count > 0) {
                            echo '<input type="submit" name="bntConcluir" id="bntConcluir" value="Concluir">';
                        }
                    } else {
                        echo "Erro na consulta: " . $conexao->error;
                    }

                    $conexao->close();
                    ?>
                </form>
            </fieldset>
        </div>
        <!-- <div>
            <h6 id="by">Feito por:<a href="www.google.com" target="_blank">Illano Ayala</a></h6>
        </div>   -->
    </div>
</body>
</html>
