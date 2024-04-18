function abrirModalDados() {
    document.getElementById('meusDadosModal').style.display = 'block';
    document.getElementById('op-user').style.display = 'none';
    buscarDadosUsuario();
}

function buscarDadosUsuario() {
    $.ajax({
        type: "POST",
        url: "../process/meusDados.php",
        dataType: "json",
        success: function (data) {
            // Preenche os campos do modal com os dados do usuário
            preencherCamposModal(data);
            console.log("Dados recebidos:", data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Erro ao buscar dados do usuário:", textStatus, errorThrown);
            console.log("Resposta do servidor:", jqXHR.responseText);
        }
    });
}


// ... Seu código JavaScript existente ...

function preencherCamposModal(data) {
    console.log("Dados recebidos para preenchimento:", data);

    // Verifica se os dados são válidos
    if (data && !data.error) {
        // Preencha os campos do modal com os dados retornados do servidor
        $("#Nome").val(data.Nome);
        $("#Email").val(data.email);
        $("#Departamento").val(data.Dep);
        $("#TS").val(data.TS);
        $("#Ramal").val(data.Ramal);
        
    } else {
        console.error("Erro ao receber dados do usuário:", data.error);
    }
}


function fecharModalDados() {
    document.getElementById('meusDadosModal').style.display = 'none';
}

// Evento de clique no link "MEUS DADOS"
document.getElementById('meusDados').addEventListener('click', abrirModalDados);

window.addEventListener('click', function (event) {
    var modal = document.getElementById('meusDadosModal');
    if (event.target == modal) {
        fecharModalDados();
    }
});