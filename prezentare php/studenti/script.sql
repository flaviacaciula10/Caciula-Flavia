create table categorii
(
    id_categorie   int auto_increment
        primary key,
    nume_categorie varchar(100) not null
);

create table produse
(
    id_produs        int auto_increment
        primary key,
    nume_produs      varchar(100)   not null,
    descriere_produs text           null,
    pret_produs      decimal(10, 2) not null,
    cantitate_stoc   int default 0  not null,
    id_categorie     int            not null,
    constraint produse_ibfk_1
        foreign key (id_categorie) references categorii (id_categorie)
);

create index id_categorie
    on produse (id_categorie);

create index idx_nume_produs
    on produse (nume_produs);

create table users
(
    id_user  int auto_increment
        primary key,
    username varchar(50)                  not null,
    parola   varchar(255)                 not null,
    email    varchar(100)                 not null,
    rol      varchar(20) default 'client' not null,
    constraint email
        unique (email),
    constraint username
        unique (username)
);

create table cos
(
    id_cos        int auto_increment
        primary key,
    id_user       int           not null,
    id_produs     int           not null,
    cantitate_cos int default 1 not null,
    constraint cos_ibfk_1
        foreign key (id_user) references users (id_user),
    constraint cos_ibfk_2
        foreign key (id_produs) references produse (id_produs)
);

create table comenzi
(
    id_comanda   int auto_increment
        primary key,
    id_user      int            not null,
    id_cos       int            not null,
    pret_comanda decimal(10, 2) not null,
    constraint comenzi_ibfk_1
        foreign key (id_user) references users (id_user),
    constraint comenzi_ibfk_2
        foreign key (id_cos) references cos (id_cos)
);

create index id_cos
    on comenzi (id_cos);

create index id_user
    on comenzi (id_user);

create index id_produs
    on cos (id_produs);

create index id_user
    on cos (id_user);


