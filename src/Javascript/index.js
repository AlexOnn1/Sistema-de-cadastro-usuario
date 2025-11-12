// Elementos do formulário
const formulario = document.getElementById('formulario');
const email = document.getElementById('email');
const confirmarEmail = document.getElementById('confirmarEmail');
const senha = document.getElementById('senha');
const confirmarSenha = document.getElementById('confirmarSenha');
const termos = document.getElementById('termos');
const btnCancelar = document.getElementById('btnCancelar');
const erroMsg = document.getElementById('erro-msg');
const modalSucesso = document.getElementById('modal-sucesso');

// Validar formato de email
function validarEmail(emailStr) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(emailStr);
}

// Limpar mensagens de erro
function limparErros() {
    erroMsg.innerHTML = '';
    erroMsg.style.display = 'none';
}

// Exibir erros
function exibirErro(mensagem) {
    erroMsg.innerHTML += `<p>${mensagem}</p>`;
    erroMsg.style.display = 'block';
}

// Validação do formulário
function validarFormulario(e) {
    e.preventDefault();
    limparErros();

    let temErro = false;

    // Validar email
    if (email.value.trim() === '') {
        exibirErro('Preencha o campo email.');
        temErro = true;
    } else if (!validarEmail(email.value.trim())) {
        exibirErro('Email inválido.');
        temErro = true;
    }

    // Validar confirmação de email
    if (confirmarEmail.value.trim() === '') {
        exibirErro('Confirme seu email.');
        temErro = true;
    } else if (email.value !== confirmarEmail.value) {
        exibirErro('Os emails não correspondem.');
        temErro = true;
    }

    // Validar senha
    if (senha.value === '') {
        exibirErro('Preencha o campo de senha.');
        temErro = true;
    } else if (senha.value.length < 8 || senha.value.length > 16) {
        exibirErro('A senha deve ter entre 8 e 16 caracteres.');
        temErro = true;
    }

    // Validar confirmação de senha
    if (confirmarSenha.value === '') {
        exibirErro('Confirme sua senha.');
        temErro = true;
    } else if (senha.value !== confirmarSenha.value) {
        exibirErro('As senhas não são iguais.');
        temErro = true;
    }

    // Validar termos
    if (!termos.checked) {
        exibirErro('Você deve concordar com os termos de serviço.');
        temErro = true;
    }

    // Se não houver erros, enviar formulário via AJAX
    if (!temErro) {
        enviarFormulario();
    }
}

// Enviar formulário via AJAX
function enviarFormulario() {
    const formData = new FormData(formulario);
    
    fetch('src/register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(dados => {
        if (dados.sucesso) {
            // Mostrar modal de sucesso
            modalSucesso.style.display = 'flex';
            formulario.reset();
            limparErros();
        } else {
            // Exibir erros do servidor
            limparErros();
            dados.erros.forEach(erro => {
                exibirErro(erro);
            });
        }
    })
    .catch(erro => {
        exibirErro('Erro ao processar o cadastro. Tente novamente.');
        console.error('Erro:', erro);
    });
}

// Cancelar formulário
function cancelarFormulario() {
    formulario.reset();
    limparErros();
}

// Event listeners
formulario.addEventListener('submit', validarFormulario);
btnCancelar.addEventListener('click', cancelarFormulario);
