const formulario = document.getElementById('formulario');
const email = document.getElementById('email');
const confirmarEmail = document.getElementById('confirmarEmail');
const senha = document.getElementById('senha');
const confirmarSenha = document.getElementById('confirmarSenha');
const termos = document.getElementById('termos');
const btnCancelar = document.getElementById('btnCancelar');
const erroMsg = document.getElementById('erro-msg');
const modalSucesso = document.getElementById('modal-sucesso');

function validarEmail(emailStr) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(emailStr);
}

function limparErros() {
    erroMsg.innerHTML = '';
    erroMsg.style.display = 'none';
}

function exibirErro(mensagem) {
    erroMsg.innerHTML += `<p>${mensagem}</p>`;
    erroMsg.style.display = 'block';
}

function validarFormulario(e) {
    e.preventDefault();
    limparErros();

    let temErro = false;

    if (email.value.trim() === '') {
        exibirErro('Preencha o campo email.');
        temErro = true;
    } else if (!validarEmail(email.value.trim())) {
        exibirErro('Email inválido.');
        temErro = true;
    }

    if (confirmarEmail.value.trim() === '') {
        exibirErro('Confirme seu email.');
        temErro = true;
    } else if (email.value !== confirmarEmail.value) {
        exibirErro('Os emails não correspondem.');
        temErro = true;
    }

    if (senha.value === '') {
        exibirErro('Preencha o campo de senha.');
        temErro = true;
    } else if (senha.value.length < 8 || senha.value.length > 16) {
        exibirErro('A senha deve ter entre 8 e 16 caracteres.');
        temErro = true;
    }

    if (confirmarSenha.value === '') {
        exibirErro('Confirme sua senha.');
        temErro = true;
    } else if (senha.value !== confirmarSenha.value) {
        exibirErro('As senhas não são iguais.');
        temErro = true;
    }

    if (!termos.checked) {
        exibirErro('Você deve concordar com os termos de serviço.');
        temErro = true;
    }

    if (!temErro) {
        enviarFormulario();
    }
}

function enviarFormulario() {
    const formData = new FormData(formulario);

    fetch('src/register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(dados => {
        if (dados.sucesso) {
            modalSucesso.style.display = 'flex';
            formulario.reset();
            limparErros();
        } else {
            limparErros();
            if (dados.erros && Array.isArray(dados.erros)) {
                dados.erros.forEach(erro => {
                    exibirErro(erro);
                });
            } else {
                exibirErro('Erro ao processar o cadastro. Tente novamente.');
            }
            if (dados.debug) {
                console.error('Debug info:', dados.debug);
            }
        }
    })
    .catch(erro => {
        exibirErro('Erro ao processar o cadastro. Verifique se o servidor está rodando.');
        console.error('Erro na requisição:', erro);
    });
}

function cancelarFormulario() {
    formulario.reset();
    limparErros();
}

formulario.addEventListener('submit', validarFormulario);
btnCancelar.addEventListener('click', cancelarFormulario);
