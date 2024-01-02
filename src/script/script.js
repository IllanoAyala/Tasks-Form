function criarDivsAleatorias(quantidade) {
    for (let i = 0; i < quantidade; i++) {
        // Criar uma nova div
        var div = document.createElement('div');
        // Adicionar a classe para estilizar
        div.className = 'random-div';
        
        // Definir posições aleatórias
        var posX = Math.random() * window.innerWidth;
        var posY = Math.random() * window.innerHeight;
        
        // Atribuir posições à div
        div.style.left = posX + 'px';
        div.style.top = posY + 'px';
        div.style.backgroundColor
        // Adicionar a div ao corpo do documento
        document.body.appendChild(div);
    }
}

function executarAoCarregarPagina() {
    // Supondo que você tenha o número de tarefas no JavaScript
    var numeroDeTarefas = 10; // Substitua pelo número real de tarefas

    // Chamar a função com base no número de tarefas
    criarDivsAleatorias(numeroDeTarefas);
}