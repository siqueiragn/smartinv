-- chave estrangeira nas tabelas para computador
-- barramento_placamae


CREATE TABLE computador (
id_computador serial PRIMARY KEY,
nome varchar,
descricao varchar
);

CREATE TABLE placa_mae (
id_placa_mae serial PRIMARY KEY,
nome varchar,
socket varchar,
--portas_usb integer,
descricao varchar,
computador integer,  
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE disco_rigido (
id_disco_rigido serial PRIMARY KEY,
nome varchar,
capacidade integer,
v_cache integer,
rpm integer,
descricao varchar,
barramento integer,
computador integer,
FOREIGN KEY (barramento) REFERENCES barramento(id_barramento),  
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE processador (
id_processador serial PRIMARY KEY,
nome varchar,
frequencia integer,
socket varchar,
descricao varchar,
computador integer,  
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE placa_video (
id_placa_video serial PRIMARY KEY,
nome varchar,
frequencia integer,
memoria integer,
tipo varchar,
descricao varchar,
barramento integer,
computador integer,
FOREIGN KEY (barramento) REFERENCES barramento(id_barramento),  
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE barramento (
id_barramento serial PRIMARY KEY,
nome varchar,
descricao varchar,
computador integer, 
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE memoria (
id_memoria serial PRIMARY KEY,
nome varchar,
frequencia integer,
capacidade integer,
tipo varchar,
descricao varchar,
computador integer, 
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE fonte (
id_fonte serial PRIMARY KEY,
nome varchar,
potencia integer,
descricao varchar,
computador integer,  
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE barramento_placamae (
id_barramento_placamae SERIAL PRIMARY KEY,
id_barramento SERIAL,
id_placa_mae SERIAL,
FOREIGN KEY (id_barramento) REFERENCES barramento(id_barramento),
FOREIGN KEY (id_placa_mae) REFERENCES placa_mae(id_placa_mae)
);

CREATE TABLE driver (
id_driver SERIAL PRIMARY KEY,
nome varchar,
velocidade integer,
descricao varchar,
barramento integer,
computador integer,
FOREIGN KEY (barramento) REFERENCES barramento(id_barramento),
FOREIGN KEY (computador) REFERENCES computador(id_computador)
);

CREATE TABLE usuario (
id_usuario SERIAL PRIMARY KEY,
email VARCHAR,
password VARCHAR
);


/*
-- pcis
FOREIGN KEY (processador) REFERENCES processador(id_processador),
FOREIGN KEY (memoria) REFERENCES memoria(id_memoria),
FOREIGN KEY (disco_rigido) REFERENCES disco_rigido(id_disco_rigido),
FOREIGN KEY (placa_video) REFERENCES placa_video(id_placa_video),
FOREIGN KEY (placa_mae) REFERENCES placa_mae(id_placa_mae)
);*/
