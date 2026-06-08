-- Active: 1779095783240@@127.0.0.1@3306@tp_backend

CREATE TABLE utilizadores (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(150) NOT NULL,
 email VARCHAR(150) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL,
 telefone VARCHAR(30),
 tipo ENUM('cliente','admin') DEFAULT 'cliente',
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO utilizadores (nome, email, password, tipo) VALUES ('admin', 'admin@admin.pt', 'admin', 'admin');

CREATE TABLE precos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 idioma_origem VARCHAR(100),
 idioma_destino VARCHAR(100),
 preco_palavra DECIMAL(10,2)
);

INSERT INTO precos (idioma_origem, idioma_destino, preco_palavra) VALUES ('Inglês','Português',3.00);

CREATE TABLE simulacoes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 utilizador_id INT NOT NULL,
 idioma_origem VARCHAR(100),
 idioma_destino VARCHAR(100),
 numero_palavras INT,
 preco_total DECIMAL(10,2),
 observacoes TEXT,
 enviada BOOLEAN DEFAULT false,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id)
);
