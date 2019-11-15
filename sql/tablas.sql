-- Crearemos tres tablas en este ejemplo
drop table if exists matriculas;
drop table if exists modulos;
drop table if exists alumnos;

-- Tablas
create table alumnos(
    idAl int primary key auto_increment,
    nomAl varchar(40) not null,
    apeAl varchar(60) not null,
    mail varchar(40),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp on update CURRENT_TIMESTAMP
);
create table modulos(
  idMod int primary key auto_increment, 
  nomMod varchar(40) not null,
  horasSem tinyint unsigned 
);
create table matriculas(
    al int,
    modulo int,
    notaFinal tinyint unsigned,
    constraint pk_mat primary key(al, modulo),
    constraint fk_mat_al foreign key(al) references alumnos(idAl) on delete cascade on update cascade,
    constraint fk_mat_mod foreign key(modulo) references modulos(idMod) on delete cascade on update cascade
);
-- Algunos Datos
insert into alumnos(nomAl, apeAl, mail) values('Juan', 'Fernandez Perez', 'correo1@mail');
insert into alumnos(nomAl, apeAl, mail) values('Ana', 'Gil Perez', 'correo2@mail');
insert into alumnos(nomAl, apeAl, mail) values('Lucas', 'Arango Perez', 'correo3@mail');
insert into alumnos(nomAl, apeAl, mail) values('Ines', 'Fernandez Sanz', 'correo5@mail');

-- Algunos Modulos
insert into modulos(nomMod, horasSem) values("DWESE", 8);
insert into modulos(nomMod, horasSem) values("HLC", 3);
insert into modulos(nomMod, horasSem) values("DWEC", 6);


