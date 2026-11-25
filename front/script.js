
const API = "http://localhost/redesocial/back/api.php";

// =========================
// LOGIN
// =========================

const formLogin = document.getElementById("formLogin");

if (formLogin) {
    formLogin.addEventListener("submit", async function(event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const senha = document.getElementById("senha").value;
        const mensagem = document.getElementById("mensagem");

        mensagem.textContent = "Verificando login...";
        mensagem.style.color = "#777";

        try {
            const resposta = await fetch(
                API + "?rota=usuario&acao=login",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email, senha })
                }
            );

            const dados = await resposta.json();

            if (!resposta.ok) {
                throw new Error(
                    dados.erro || dados.mensagem || "Erro ao entrar."
                );
            }

            sessionStorage.setItem(
                "usuario",
                JSON.stringify(dados.usuario)
            );

            mensagem.style.color = "green";
            mensagem.textContent = "Login realizado com sucesso!";

            window.location.href = "feed.html";

        } catch (erro) {
            mensagem.style.color = "red";
            mensagem.textContent = erro.message;
        }
    });
}


// =========================
// CADASTRO
// =========================

const formCadastro = document.getElementById("formCadastro");

if (formCadastro) {
    formCadastro.addEventListener("submit", async function(event) {
        event.preventDefault();

        const nome = document.getElementById("nome").value.trim();
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const senha = document.getElementById("senha").value;
        const mensagem = document.getElementById("mensagem");

        mensagem.textContent = "Cadastrando...";
        mensagem.style.color = "#777";

        try {
            const resposta = await fetch(
                API + "?rota=usuario",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        nome,
                        username,
                        email,
                        senha
                    })
                }
            );

            const dados = await resposta.json();

            if (!resposta.ok) {
                throw new Error(
                    dados.erro || dados.mensagem || "Erro ao cadastrar."
                );
            }

            mensagem.style.color = "green";
            mensagem.textContent = "Cadastro realizado com sucesso! 💗";

            formCadastro.reset();

        } catch (erro) {
            mensagem.style.color = "red";
            mensagem.textContent = erro.message;
        }
    });
}
