-- chave estrangeira nas tabelas para computador
-- barramento_placamae

CREATE TABLE placa_mae (
id_placa_mae serial PRIMARY KEY,
nome varchar,
--qtde_sata integer,
--qtde_ide integer,
--qtde_pci integer,
--qtde_pci_e integer,
socket integer,
portas_usb integer,
descricao varchar,
computador integer
);
CREATE TABLE disco_rigido (
id_disco_rigido serial PRIMARY KEY,
nome varchar,
v_cache integer,
rpm integer,
descricao varchar,
computador integer
);

CREATE TABLE processador (
id_processador serial PRIMARY KEY,
nome varchar,
frequencia integer,
socket varchar,
descricao varchar,
computador integer
);

CREATE TABLE placa_video (
id_placa_video serial PRIMARY KEY,
nome varchar,
frequencia integer,
memoria integer,
barramento varchar,
descricao varchar,
computador integer
);

CREATE TABLE barramento (
id_barramento serial PRIMARY KEY,
nome varchar,
descricao varchar,
computador integer
);

CREATE TABLE memoria (
id_memoria serial PRIMARY KEY,
nome varchar,
frequencia integer,
descricao varchar,
computador integer
);

CREATE TABLE fonte (
id_fonte serial PRIMARY KEY,
nome varchar,
potencia integer,
descricao varchar,
computador integer
);




CREATE TABLE computador (
id_computador serial PRIMARY KEY,
nome varchar
);

/*
-- pcis
FOREIGN KEY (processador) REFERENCES processador(id_processador),
FOREIGN KEY (memoria) REFERENCES memoria(id_memoria),
FOREIGN KEY (disco_rigido) REFERENCES disco_rigido(id_disco_rigido),
FOREIGN KEY (placa_video) REFERENCES placa_video(id_placa_video),
FOREIGN KEY (placa_mae) REFERENCES placa_mae(id_placa_mae)
);*/