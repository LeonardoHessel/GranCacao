$(document).ready(function(){
    //Função de "ao clickar" no botão
    $("#btn-cadastro").click(function(){
        //Declaração das variaveis
        let Senha, Repetir_senha, Nome, Email;
        //Pegando os valores HTML
        Senha = $("#password-field").val();
        Repetir_senha = $("#Repetir_senha").val();
        Email = $("#Email").val();
        Nome = $("#Nome").val();
        //========================================
        //Função de validação do nome
        if(validar_nome(Nome) == true) 
            $("#Nome").css("border-color", "green")
        else
        {
            $("#Nome").css("border-color", "red")
        }
        //==========================================
        //Função de validação do email
        if(validar_email(Email) == true) 
            $("#Email").css("border-color", "green")
        else
        {
            $("#Email").css("border-color", "red")
        }
        //==========================================
        //função de validação da senha
        if(validar_Senha(Senha) == true)
            $("#password-field").css("border-color", "green")
        else
        {
            $("#password-field").css("border-color", "red")
        }
        //==========================================
        //função de validação da repetição da senha
        if(validar_resenha(Senha, Repetir_senha) == true)
            $("#Repetir_senha").css("border-color", "green")
        else
        {
            $("#Repetir_senha").css("border-color", "red")
            $("#password-field").css("border-color", "red")
        }

        if(Nome == '<script>' || Nome == '</script>') Nome.replace(/</i, "&gt").replace(/>/i, "&gt");

        if(Email == '<script>' || Email == '</script>') Email.replace(/</i, "&gt").replace(/>/i, "&gt");

        if(Senha == '<script>' || Senha == '</script>') Senha.replace(/</i, "&gt").replace(/>/i, "&gt");

        if(Repetir_senha == '<script>' || Repetir_senha == '</script>') Repetir_senha.replace(/</i, "&gt").replace(/>/i, "&gt");

        //Var qtd de erros
        let qtderros = $('input.is-invalid').length

        //Se a quantidade de erros for igual a 0, realize o cadastro
        if(qtderros == 0)
        {
            $.ajax({
                url:"http://localhost/.../server/webservice.php",
                method: "get",
                data:{

                },
                timeout: 3000
            })
        }
    })
})