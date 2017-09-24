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
    fecha_inicio date not null,
    fecha_final date not null,
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

--------------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE consultarUsuarioTodos()
  BEGIN
   select * from usuarios;
  END $$
DELIMITER ;

--------------------------------------------------------------------------------

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

--------------------------------------------------------------------------------

DELIMITER $$
CREATE PROCEDURE actualizarUsuario(IN id int,
IN usuario varchar(10),
IN contrasena varchar(255), IN estado BOOLEAN)
  BEGIN

UPDATE `consensus`.`usuarios` set usuario = usuario, 
                              contrasena = md5(contrasena),
                              estado = estado
where id = id;   

  END $$
DELIMITER ;

--------------------------------------------------------------------------------


DELIMITER $$
CREATE PROCEDURE consultarUsuario(IN inID int)
  BEGIN
   select * from usuarios where id=inID;
  END $$
DELIMITER ;

--------------------------------------------------------------------------------


DELIMITER $$
CREATE PROCEDURE eliminarUsuario(IN inUsuario varchar(10))
  BEGIN
   delete from usuarios where usuario like concat('%',inUsuario,'%');
  END $$
DELIMITER ;


--------------------------------------------------------------------------------

DELIMITER //
CREATE PROCEDURE consultarEventoPorID(IN idEvento int)
  BEGIN
   select * from eventos where id = idEvento;
  END //
DELIMITER ;

--------------------------------------------------------------------------------

DELIMITER //
CREATE PROCEDURE consultarEventoPorNombre(IN inNombreEvento varchar(50))
  BEGIN
   select * from eventos where nombre like concat('%',inNombreEvento,'%');
  END //
DELIMITER ;

