function validar(event) {
    event.preventDefault();

    let form = document.getElementById("contactForm");
    let nome = document.getElementById("form-nome").value;
    let email = document.getElementById("form-email").value;
    let msg = document.getElementById("form-msg").value;

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let regexNome = /^[A-Za-zÀ-ÿ]+(\s[A-Za-zÀ-ÿ]+)*$/;

    if (nome.length < 3 || !regexNome.test(nome)) {
        showModal("Nome inválido");
        return;
    }

    if (!regexEmail.test(email)) {
        showModal("Email inválido");
        return;
    }

    if (msg.length < 3) {
        showModal("Sem mensagem");
        return;
    }

    fetch("https://formsubmit.co/ajax/fcruz.teste.web@gmail.com", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nome: nome,
            email: email,
            mensagem: msg
        })
    })
    .then(response => response.json())
    .then(data => {
        showModal("Mensagem enviada com sucesso!");
        form.reset();
    })
    .catch(error => {
        showModal("Erro ao enviar. Tenta novamente.");
    });
}

function showModal(texto) {
    document.getElementById("modal-text").innerText = texto;

    let modal = new bootstrap.Modal(document.getElementById('myModal'));
    modal.show();
}