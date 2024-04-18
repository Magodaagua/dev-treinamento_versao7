function filtrarCursos() {
    const categoriaSelecionada = document.getElementById('Categoria').value;
    const valorPesquisar = document.getElementById('valor_pesquisar').value; // Corrigido para pegar o valor correto
    const url = `pesquisa.php?pesquisar=${encodeURIComponent(valorPesquisar)}&categoria=${categoria}&subcategoria=${categoriaSelecionada}`;
    window.location.href = url;
}

function limparFiltro() {
    //document.getElementById('Categoria').value = 'default';
    const url = `curso.php?Dep=${categoria}`;
    window.location.href = url;
    // Aqui você pode adicionar lógica adicional se necessário após limpar o filtro
}
