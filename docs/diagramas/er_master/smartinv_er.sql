
/* Drop Tables */

DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS public.barramento_placamae;
DROP TABLE IF EXISTS public.disco_rigido;
DROP TABLE IF EXISTS public.driver;
DROP TABLE IF EXISTS public.placa_video;
DROP TABLE IF EXISTS public.barramento;
DROP TABLE IF EXISTS public.fonte;
DROP TABLE IF EXISTS public.memoria;
DROP TABLE IF EXISTS public.placa_mae;
DROP TABLE IF EXISTS public.processador;
DROP TABLE IF EXISTS public.computador;




/* Create Tables */

CREATE TABLE usuario
(
	id_usuario serial NOT NULL UNIQUE,
	login varchar NOT NULL,
	password varchar NOT NULL,
	email varchar NOT NULL,
	PRIMARY KEY (id_usuario)
) WITHOUT OIDS;


CREATE TABLE public.barramento
(
	id_barramento serial NOT NULL,
	nome varchar,
	descricao varchar,
	CONSTRAINT barramento_pkey PRIMARY KEY (id_barramento)
) WITHOUT OIDS;


CREATE TABLE public.barramento_placamae
(
	id_barramento_placamae serial NOT NULL,
	id_barramento int NOT NULL,
	id_placa_mae int NOT NULL,
	CONSTRAINT barramento_placamae_pkey PRIMARY KEY (id_barramento_placamae)
) WITHOUT OIDS;


CREATE TABLE public.computador
(
	id_computador serial NOT NULL,
	nome varchar,
	descricao varchar,
	CONSTRAINT computador_pkey PRIMARY KEY (id_computador)
) WITHOUT OIDS;


CREATE TABLE public.disco_rigido
(
	id_disco_rigido serial NOT NULL,
	nome varchar,
	v_cache int,
	rpm int,
	descricao varchar,
	computador int,
	id_barramento int NOT NULL,
	CONSTRAINT disco_rigido_pkey PRIMARY KEY (id_disco_rigido)
) WITHOUT OIDS;


CREATE TABLE public.driver
(
	id_driver serial NOT NULL,
	nome varchar,
	descricao varchar,
	computador serial NOT NULL,
	id_barramento int NOT NULL,
	id_computador int,
	CONSTRAINT processador_pkey PRIMARY KEY (id_driver)
) WITHOUT OIDS;


CREATE TABLE public.fonte
(
	id_fonte serial NOT NULL,
	nome varchar,
	potencia int,
	descricao varchar,
	computador int NOT NULL,
	CONSTRAINT fonte_pkey PRIMARY KEY (id_fonte)
) WITHOUT OIDS;


CREATE TABLE public.memoria
(
	id_memoria serial NOT NULL,
	nome varchar,
	frequencia int,
	tipo varchar,
	descricao varchar,
	computador int NOT NULL,
	CONSTRAINT memoria_pkey PRIMARY KEY (id_memoria)
) WITHOUT OIDS;


CREATE TABLE public.placa_mae
(
	id_placa_mae serial NOT NULL,
	nome varchar,
	socket int,
	descricao varchar,
	computador int NOT NULL,
	CONSTRAINT placa_mae_pkey PRIMARY KEY (id_placa_mae)
) WITHOUT OIDS;


CREATE TABLE public.placa_video
(
	id_placa_video serial NOT NULL,
	nome varchar,
	frequencia int,
	barramento varchar,
	memoria int,
	descricao varchar,
	computador int,
	id_barramento int NOT NULL,
	CONSTRAINT placa_video_pkey PRIMARY KEY (id_placa_video)
) WITHOUT OIDS;


CREATE TABLE public.processador
(
	nome varchar,
	id_driver serial NOT NULL,
	frequencia int,
	descricao varchar,
	socket varchar,
	computador int NOT NULL,
	CONSTRAINT processador_pkey PRIMARY KEY (id_driver)
) WITHOUT OIDS;



/* Create Foreign Keys */

ALTER TABLE public.barramento_placamae
	ADD CONSTRAINT barramento_placamae_id_barramento_fkey FOREIGN KEY (id_barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.disco_rigido
	ADD FOREIGN KEY (id_barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE public.driver
	ADD FOREIGN KEY (id_barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE public.placa_video
	ADD FOREIGN KEY (id_barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE public.disco_rigido
	ADD CONSTRAINT disco_rigido_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.driver
	ADD FOREIGN KEY (id_computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE public.fonte
	ADD CONSTRAINT fonte_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.memoria
	ADD CONSTRAINT memoria_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.placa_mae
	ADD CONSTRAINT placa_mae_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.placa_video
	ADD CONSTRAINT placa_video_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.processador
	ADD CONSTRAINT processador_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.barramento_placamae
	ADD CONSTRAINT barramento_placamae_id_placa_mae_fkey FOREIGN KEY (id_placa_mae)
	REFERENCES public.placa_mae (id_placa_mae)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;



