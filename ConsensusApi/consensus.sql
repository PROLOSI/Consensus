drop table if exists usuarios;
create table usuarios(

    id int AUTO_INCREMENT primary key,
    usuario varchar(10) not null unique,
    contrasena varchar(255) not null,
    correo varchar(255) not null unique,
    telefono varchar(8) not null,
    adress varchar(255) not null unique,
    estado BOOLEAN

);

drop table if exists eventos;
create table eventos(
    id int AUTO_INCREMENT primary key,
    nombre varchar(50) not null,
    fecha_inicio datetime not null,
    fecha_final datetime not null,
    tipo_votacion int(3) not null,
    tipo_voto BOOLEAN not null default false,
    avance BOOLEAN not null default false,
    cantidad_votos_permitidos int not null
);

drop table if exists candidatos;
create table candidatos(
    id int AUTO_INCREMENT,
    nombre varchar(50) not null,
    id_evento int not null,
    constraint pk_llave_candidatos primary key (id,nombre,id_evento),
    constraint fk_evento_asociado foreign key (id_evento) references eventos(id)
);

-- ------------------------------------------------------------------------------

drop procedure if exists consultarUsuarioTodos;
DELIMITER $$
CREATE PROCEDURE consultarUsuarioTodos()
  BEGIN
   select * from usuarios;
  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists insertarUsuarios;
DELIMITER $$
CREATE PROCEDURE insertarUsuarios(IN id int,
IN usuario varchar(10),
IN contrasena varchar(255),
IN correo varchar(255),
IN telefono varchar(8),
IN adress varchar(255),
IN estado BOOLEAN,
OUT resultado BOOLEAN)
  BEGIN

INSERT INTO `consensus`.`usuarios` (`id`, `usuario`,`contrasena`, `correo`, `telefono`, `adress`, `estado`) VALUES (id, usuario, contrasena, correo, telefono, adress, estado);   

if exists (select id from `consensus`.`usuarios` where id = (select last_insert_id())) then

set resultado = 1;

else

set resultado = 0;

end if;

  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists actualizarUsuario;
DELIMITER $$
CREATE PROCEDURE actualizarUsuario(IN inId int,
IN inUsuario varchar(10),
IN inContrasena varchar(255), IN inEstado BOOLEAN)
  BEGIN

UPDATE `consensus`.`usuarios` set usuario = inUsuario, 
                              contrasena = md5(inContrasena),
                              estado = inEstado
where id = inId;   

  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------

drop procedure if exists consultarUsuarioID;
DELIMITER $$
CREATE PROCEDURE consultarUsuarioID(IN inID int)
  BEGIN
   select * from usuarios where id=inID;
  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists consultarUsuarioUser;
DELIMITER $$
CREATE PROCEDURE consultarUsuarioUser(IN inUsuario varchar(10))
  BEGIN
   select * from usuarios where usuario like concat('%',inUsuario,'%');
  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------

drop procedure if exists eliminarUsuario;
DELIMITER $$
CREATE PROCEDURE eliminarUsuario(IN inUsuario varchar(10))
  BEGIN
   delete from usuarios where usuario like concat('%',inUsuario,'%');
  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists crearEventos;
DELIMITER $$
CREATE PROCEDURE crearEventos(
IN inId int,
IN inNombre varchar(50),
IN inFecha_inicio datetime,
IN inFecha_final datetime,
IN inTipo_votacion int(3),
IN inTipo_voto BOOLEAN,
IN inAvance BOOLEAN,
IN inCantidad_votos_permitidos int,
OUT resultado BOOLEAN)
  BEGIN

INSERT INTO `consensus`.`eventos` (`id`, `nombre`,`fecha_inicio`, `fecha_final`, `tipo_votacion`, `tipo_voto`, `avance`, `cantidad_votos_permitidos`) 
VALUES (inId, inNombre, inFecha_inicio, inFecha_final, inTipo_votacion, inTipo_voto, inAvance,inCantidad_votos_permitidos);   

if exists (select id from `consensus`.`eventos` where id = (select last_insert_id())) then

set resultado = 1;

else

set resultado = 0;

end if;

  END $$
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists consultarEventos;
DELIMITER //
CREATE PROCEDURE consultarEventos()
  BEGIN
   select * from eventos;
  END //
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists consultarEventoPorID;
DELIMITER //
CREATE PROCEDURE consultarEventoPorID(IN idEvento int)
  BEGIN
   select * from eventos where id = idEvento;
  END //
DELIMITER ;

-- ------------------------------------------------------------------------------
drop procedure if exists consultarEventoPorNombre;
DELIMITER //
CREATE PROCEDURE consultarEventoPorNombre(IN inNombreEvento varchar(50))
  BEGIN
   select * from eventos where nombre like concat('%',inNombreEvento,'%');
  END //
DELIMITER ;


