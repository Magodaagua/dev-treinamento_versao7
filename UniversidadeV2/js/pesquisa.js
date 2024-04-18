function submitForm() {
    document.querySelector('.formulariopesquisaescrita').submit();
}

function preencherCategoria() {
    const categoriaSelecionada = document.getElementById('categoria').value;
    const pesquisapornome = document.getElementById('pesquisapornome').value; // Obtém o valor do campo de pesquisa por nome
    const url = `curso.php?pesquisar=${pesquisapornome}&subcategoria=${categoriaSelecionada}`;
    window.location.href = url;
    return false; // Para evitar o envio padrão do formulário
}
