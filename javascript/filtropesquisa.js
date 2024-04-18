function filtrarCursos() {
    const categoriaSelecionada = document.getElementById('Categoria').value;
    const valorPesquisar = document.getElementById('valor_pesquisar').value;

    const url = `pesquisar.php?pesquisar=${encodeURIComponent(valorPesquisar)}&categoria=${categoria}&subcategoria=${categoriaSelecionada}`;
    window.location.href = url;
}

function limparFiltro() {
    const valorPesquisar = document.getElementById('valor_pesquisar').value;
    const url = `pesquisar.php?pesquisar=${encodeURIComponent(valorPesquisar)}&categoria=${categoria}`;
    window.location.href = url;
    // Adicione lógica adicional, se necessário, após limpar o filtro
}
