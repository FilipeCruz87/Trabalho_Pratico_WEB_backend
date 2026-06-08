<?php require_once __DIR__ . '/../db/Database.php';?>
  <main class="container-fluid d-flex justify-content-center align-items-center text-center p-3 mb-0 rounded flex-grow-1">
    <div class="row w-100 align-items-stretch">
            <div class="col-12 col-md-4 h-100 d-flex flex-column justify-content-center align-items-center">
                <h3 class="mb-4 animate-on-load fade-up" style="animation-delay: 0.1s;">Contactos</h3>
                <ul class="list-unstyled mb-4 d-flex flex-column gap-2 text-start animate-on-load fade-up" style="animation-delay: 0.1s;">
                    <li><i class="bi bi-envelope-at"></i><a href="mailto:fcruz.teste.web@gmail.com" target="_blank" rel="noopener noreferrer">inesnc.trad@gmail.com</a></li>
                    <li><i class="bi bi-geo-alt"></i>Porto, Portugal</li>
                    <li><i class="bi bi-clock"></i>GMT +0 / WEST +1</li>
                    <li><i class="bi bi-globe"></i><a href="https://linktr.ee/inesnc.trad" target="_blank" rel="noopener noreferrer">linktr.ee/inesnc.trad</a></li>
                </ul>
                <img src="../assets/img/qr.jpg" alt="erro" class="img-fluid animate-on-load fade-down mb-2" style="animation-delay: 0.1s;" width="200">
            </div>
            <div class="col-12 col-md-8 h-100 d-flex flex-column align-items-center align-items-md-center text-md-start">
                <h3 class="mb-2 mt-2 animate-on-load fade-up" style="animation-delay: 0.3s;">Formulário de Contacto</h3>
                <form form id="contactForm" onsubmit="validar(event)" class="w-100 animate-on-load fade-down pe-md-4" style="animation-delay: 0.3s;">
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="mb-3">
                                <label class="form-label" for="form-nome">Nome:</label>
                                <input type="text" name="nome" id="form-nome" class="form-control" placeholder="min. 3 caracteres">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="mb-3">
                                <label class="form-label" for="form-email">Email:</label>
                                <input type="email" name="email" id="form-email" class="form-control" placeholder="email@xyz.abc">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="form-msg">Mensagem:</label>
                        <textarea name="mensagem" class="form-control" rows="5" id="form-msg" placeholder="Escreve aqui a tua mensagem (min. 3 caracteres)"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-3 flex-column flex-md-row">
                        <button type="reset" class="btn btn-danger">Anular</button>
                        <button type="submit" class="btn btn-primary">Submeter</button>
                    </div>
                </form>
            </div>
        </div>