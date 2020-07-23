function RemoveVerificacao(){
    $("input").removeClass("is-invalid");
    $("input").removeClass("is-valid");
}

$(document).ready(function(){
    // FUNCIONALIDADE DE EXIBIR/OCULTAR SENHA
    $(".toggle-password").click(function(){

        $(this).toggleClass("fas fa-eye-slash");
        var input = $($(this).attr("toggle"));

        if(input.attr("type") == "password")
            input.attr("type", "text");
        else 
            input.attr("type", "password");
        });
    //Função de "ao clickar" no botão
    $("#btn-cadastro").click(function(){
        // Faz a remoção das classes de verificação
        RemoveVerificacao();

        //Declaração das variaveis
        let Email, Senha, RepetirSenha;
        //Pegando os valores HTML
        Email = $("#txtEmail").val();
        Senha = $("#txtSenha").val();
        RepetirSenha = $("#txtRepetir_senha").val();
         //==========================================
        //Função de validação do email
        if(validar_email(Email))
            $("#txtEmail").addClass("is-valid");
        else
            $("#txtEmail").addClass("is-invalid");
        //==========================================
        //função de validação da senha
        if(validar_Senha(Senha))
            $("#txtSenha").css("border-color", "green");
        else
            $("#txtSenha").css("border-color", "red");
        //==========================================
        //função de validação da repetição da senha
        if(validar_resenha(Senha, RepetirSenha))
            $("#txtRepetir_senha").addClass("is-valid");
        else
            $("#txtRepetir_senha").addClass("is-invalid");
        //==========================================

        if(Email == '<script>' || Email == '</script>') Email.replace(/</i, "&gt").replace(/>/i, "&gt");
    
        if(Senha == '<script>' || Senha == '</script>') Senha.replace(/</i, "&gt").replace(/>/i, "&gt");
    
        if(RepetirSenha == '<script>' || RepetirSenha == '</script>') RepetirSenha.replace(/</i, "&gt").replace(/>/i, "&gt");
        
        //Var qtd de erros
        let qtderros = $('input.is-invalid').length

        //Se a quantidade de erros for igual a 0, realize o cadastro
        if(qtderros == 0){
            $.ajax({
                url:"http://localhost/.../server/webservice.php",
                method: "POST",
                data:{
                    // FAZER O ENVIO DE DADOS
                },
                timeout: 3000
            })
        }
        else
            alert("Preencha os campos inválidos corretamente!");
    });
});