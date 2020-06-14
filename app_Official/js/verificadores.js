//Função da validação do nome
function validar_nome(Nome)
{   
    //Variavel que vai armazenar as separações pelo espaço
    let separador = Nome.split(' ')
    if(separador.length == 1 || separador.length == 0) return false
    else return true
}

//Função de validação do Email
function validar_email(Email)
{
    //Variavel que vai armazenar as separações pelo @
    let separador = Email.split('@')

    if(separador.length == 2)
    {
        //armazenar as separações pelo .
        separador = Email.split(".")
        if(separador.length == 2) return true
        else return false
    }
    else return false
}

//Função da validação da senha
function validar_Senha(Senha)
{   
    //Deve conter no minimo 6 digitos
    if(Senha.length < 6) return false
    else return true
}

function validar_resenha(Senha, Repetir_senha)
{
    //Se ela for nula, false
    if(Repetir_senha.length == 0) return false

    //Se elas forem iguais, true
    if(Senha == Repetir_senha) return true
    //Se não false
    else return false
}