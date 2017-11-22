
/* Drop Tables */

DROP TABLE IF EXISTS public.algoritmo;
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
DROP TABLE IF EXISTS public.usuario;




/* Create Tables */

CREATE TABLE public.algoritmo
(
	id_algoritmo serial NOT NULL,
	id_placa_mae int,
	id_processador int,
	id_fonte int,
	id_memoria int,
	id_disco_rigido int,
	id_computador int,
	CONSTRAINT algoritmo_pkey PRIMARY KEY (id_algoritmo)
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
	id_barramento int,
	id_placa_mae int,
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
	capacidade int,
	v_cache int,
	rpm int,
	descricao varchar,
	barramento int,
	computador int,
	CONSTRAINT disco_rigido_pkey PRIMARY KEY (id_disco_rigido)
) WITHOUT OIDS;


CREATE TABLE public.driver
(
	id_driver serial NOT NULL,
	nome varchar,
	velocidade int,
	descricao varchar,
	barramento int,
	computador int,
	CONSTRAINT driver_pkey PRIMARY KEY (id_driver)
) WITHOUT OIDS;


CREATE TABLE public.fonte
(
	id_fonte serial NOT NULL,
	nome varchar,
	potencia int,
	descricao varchar,
	computador int,
	CONSTRAINT fonte_pkey PRIMARY KEY (id_fonte)
) WITHOUT OIDS;


CREATE TABLE public.memoria
(
	id_memoria serial NOT NULL,
	nome varchar,
	frequencia int,
	capacidade int,
	tipo varchar,
	descricao varchar,
	computador int,
	CONSTRAINT memoria_pkey PRIMARY KEY (id_memoria)
) WITHOUT OIDS;


CREATE TABLE public.placa_mae
(
	id_placa_mae serial NOT NULL,
	nome varchar,
	socket varchar,
	descricao varchar,
	computador int,
	slot_memoria varchar,
	CONSTRAINT placa_mae_pkey PRIMARY KEY (id_placa_mae)
) WITHOUT OIDS;


CREATE TABLE public.placa_video
(
	id_placa_video serial NOT NULL,
	nome varchar,
	frequencia int,
	memoria int,
	tipo varchar,
	descricao varchar,
	barramento int,
	computador int,
	CONSTRAINT placa_video_pkey PRIMARY KEY (id_placa_video)
) WITHOUT OIDS;


CREATE TABLE public.processador
(
	id_processador serial NOT NULL,
	nome varchar,
	frequencia int,
	socket varchar,
	descricao varchar,
	computador int,
	CONSTRAINT processador_pkey PRIMARY KEY (id_processador)
) WITHOUT OIDS;


CREATE TABLE public.usuario
(
	id_usuario serial NOT NULL,
	email varchar,
	password varchar,
	CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario)
) WITHOUT OIDS;



/* Create Foreign Keys */

ALTER TABLE public.barramento_placamae
	ADD CONSTRAINT barramento_placamae_id_barramento_fkey FOREIGN KEY (id_barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.disco_rigido
	ADD CONSTRAINT disco_rigido_barramento_fkey FOREIGN KEY (barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.driver
	ADD CONSTRAINT driver_barramento_fkey FOREIGN KEY (barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.placa_video
	ADD CONSTRAINT placa_video_barramento_fkey FOREIGN KEY (barramento)
	REFERENCES public.barramento (id_barramento)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
;


ALTER TABLE public.disco_rigido
	ADD CONSTRAINT disco_rigido_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.driver
	ADD CONSTRAINT driver_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.fonte
	ADD CONSTRAINT fonte_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.memoria
	ADD CONSTRAINT memoria_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.placa_mae
	ADD CONSTRAINT placa_mae_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.placa_video
	ADD CONSTRAINT placa_video_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.processador
	ADD CONSTRAINT processador_computador_fkey FOREIGN KEY (computador)
	REFERENCES public.computador (id_computador)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;


ALTER TABLE public.barramento_placamae
	ADD CONSTRAINT barramento_placamae_id_placa_mae_fkey FOREIGN KEY (id_placa_mae)
	REFERENCES public.placa_mae (id_placa_mae)
	ON UPDATE NO ACTION
	ON DELETE SET NULL
;



