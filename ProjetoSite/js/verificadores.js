//Função de validação do Email
function validar_email(Email){
    // Verifica se o email possui algum espaço
    if ((Email.split(" ")).length > 1) 
        return false;  

    //Variavel que vai armazenar as separações pelo espaço
    var separador = Email.split("@");
    if (separador.length == 2)
        return separador[1].split(".").length > 1;
    else 
        return false;
}

//Função da validação da senha
function validar_Senha(Senha){  
    // A senha deve conter no minimo seis caracteres e não pode conter nenhum cacter especial 
    if(Senha.length < 6 || Senha.match(/[!"#$%&'()*+,:;<=>?@[\]^`{|}~]/)) 
        return false
    else 
        return true
}

function validar_resenha(Senha, Repetir_senha){
    // As senhas devem ser as mesmas, a senha não poder ser um valor nulo e não pode conter nenhum cacter especial
    if(Repetir_senha!=Senha || Repetir_senha.length==0 || Repetir_senha.match(/[!"#$%&'()*+,:;<=>?@[\]^`{|}~]/))
        return false
    else
        return true
}











































