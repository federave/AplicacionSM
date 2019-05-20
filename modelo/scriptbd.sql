

use basededatos_administracion;


create table PreciosDispensadores(
id int auto_increment,
fecha datetime,
vertedor real,
dispenser real,
constraint pk primary key(id)
);


create table VentaVertedores(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int,
especial boolean,
precioespecial real
);
select * from ventavertedores where IDRepartidor=1

create table EntregaVertedores(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int
);


create table CambioVertedores(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int
);









create table VentaDispensers(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int,
especial boolean,
precioespecial real
);


create table EntregaDispensers(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int
);


create table CambioDispensers(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int
);


create table RetiroDispensers(
idcliente int,
iddireccion int,
idrepartidor int,
fecha datetime,
cantidad int
);





