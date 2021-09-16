drop table if exists messages;
DROP table if exists client__messages;
create table messages(
    id_message int primary key AUTO_INCREMENT,
    titre_sms varchar(50),
    type_sms varchar(50) not null,
    message varchar(255) not null ,
    description_sms varchar(255) null ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists versements;
create table versements(
    id_versement int primary key AUTO_INCREMENT,
    reference varchar(50) null ,
    montant_versement float not null,
    description varchar(255) null ,
    id_user int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists fournisseurs;
create table fournisseurs(
    id_fournisseur int primary key AUTO_INCREMENT,
    nom_fr varchar(100) not null ,
    email_fr varchar(100) not null,
    phone_fr varchar(20) not null ,
    adresse_fr varchar(255) null ,
    description_fr varchar(255) null ,
    id_user int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists message_envoyes;
create table message_envoyes(
    id_message_envoye int primary key AUTO_INCREMENT,
    id_message int not null ,
    id_client int not null,
    nom_client varchar(100) null ,
    telephone_client varchar(20) null,
    message varchar(255) not null ,
    description_sms varchar(255) null ,
    statut int null ,
    quantite int default 1,
    id_user int null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP table if exists client_messages;
create table client_messages(
    id_clientmessage int primary key AUTO_INCREMENT,
    id_client int not null ,
    id_message int not null,
    id_user int null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER  table caisses add column raison varchar(100) null ;
