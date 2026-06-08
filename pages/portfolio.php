<?php require_once __DIR__ . '/../db/Database.php';?>
<main class="container-fluid d-flex justify-content-center align-items-center text-center p-3 mb-0 rounded flex-grow-1">
    <ul class="nav nav-tabs justify-content-center animate-on-load fade-up mb-2" style="animation-delay: 0.1s;" id="gameTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#intro" type="button">Introdução</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aoe4" type="button">Age of Empires IV</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aom" type="button">Age of Mythology</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ara" type="button">Ara</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#towerborn" type="button">Towerborn</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fs2024" type="button">Flight Simulator</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#jdm" type="button">JDM</button>
      </li>
    </ul>
    <div class="tab-content pt-3 animate-on-load fade-down mb-2" style="animation-delay: 0.3s;">
      <div class="tab-pane fade show active" id="intro">
        <div class="row g-3 align-items-center my-md-5 px-md-3">
          <div class="d-flex flex-column justify-content-center align-items-center p-3 tab-text">
            <p>Embora a maior parte do meu trabalho na área da localização de jogos esteja sob NDA, tive direito a vários créditos.<br>Para trabalho uso principalmente MemoQ e Microsoft Excel, mas também já usei outras ferramentas CAT, como Phrase, Crowdin e Trados, para além de software proprietário.<br>Já trabalhei em vários géneros, como 4x, racing, simulação de voo, sandbox, side-scrollers e RPGs.<br>Tenho cerca de 10 horas em LQA.<br>Entre diálogos, elementos UI/ UX, material de marketing e documentação legal, já traduzi e pos-editei cerca de 1 204 000 Palavras.</p>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="aoe4">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Lançado em outubro de 2021.<br>Traduzimos diálogos, elementos da interface, menus e materiais de marketing, assim como outros materiais escritos.<br>No total, traduzi cerca de 37 mil palavras desde 2023.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo1.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo1.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="aom">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Lançado em setembro de 2024.<br>Traduzimos diálogos, elementos da interface, menus e materiais de marketing, assim como outros materiais escritos.<br>No total, traduzi cerca de 74 mil palavras num período de produção de dois anos.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo2.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo2.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="ara">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Lançado em setembro de 2024.<br>Traduzimos diálogos, elementos da interface, menus, materiais de marketing e textos de trivia, assim como outros materiais escritos.<br>No total, traduzi cerca de 177 mil palavras num período de produção de ano e meio.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo3.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo3.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="towerborn">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Em acesso antecipado desde setembro de 2024 e lançado em fevereiro de 2026.<br>Traduzimos diálogos, elementos da interface, menus e materiais de marketing, assim como outros materiais escritos.<br>No total, traduzi cerca de 68 mil palavras no período de um ano.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo4.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo4.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="fs2024">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Lançado em novembro de 2024.<br>Traduzimos diálogos, elementos da interface, menus, instruções de voo, materiais de marketing, assim como outros materiais escritos.<br>No total, traduzi cerca de 193 mil palavras até ao momento.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo5.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo5.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="jdm">
        <div class="row g-3 align-items-center">
          <div class="col-md-6 p-3 tab-text">
            <p>Lançado em maio de 2025.<br>Traduzimos e editámos diálogos, elementos de interface, menus, instruções de condução, instruções de corridas automóveis, assim como outros materiais escritos.</p>
          </div>
          <div class="col-md-6 d-flex align-items-center flex-column gap-2">
            <img src="../assets/img/jogo6.1.jpg" class="img-fluid img-tab" alt="erro">
            <img src="../assets/img/jogo6.2.jpg" class="img-fluid img-tab" alt="erro">
          </div>
        </div>
      </div>
    </div>