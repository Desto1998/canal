drop table if exists messages;
DROP table if exists client__messages;
create table messages
(
    id_message      int primary key AUTO_INCREMENT,
    titre_sms       varchar(50),
    type_sms        varchar(50)  not null,
    message         varchar(255) not null,
    description_sms varchar(255) null,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists versements;
create table versements
(
    id_versement      int primary key AUTO_INCREMENT,
    reference         varchar(50) null,
    montant_versement float not null,
    description       varchar(255) null,
    id_user           int   not null,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists versement_achats;
create table versement_achats
(
    id_achat          int primary key AUTO_INCREMENT,
    montant_achat     float not null,
    description_achat varchar(255) null,
    id_user           int   not null,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists fournisseurs;
create table fournisseurs
(
    id_fournisseur int primary key AUTO_INCREMENT,
    nom_fr         varchar(100) not null,
    email_fr       varchar(100) not null,
    phone_fr       varchar(20)  not null,
    adresse_fr     varchar(255) null,
    description_fr varchar(255) null,
    id_user        int          not null,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists message_envoyes;
create table message_envoyes
(
    id_message_envoye int primary key AUTO_INCREMENT,
    id_message        int          not null,
    id_client         int          not null,
    nom_client        varchar(100) null,
    telephone_client  varchar(255) null,
    message           varchar(255) not null,
    description_sms   varchar(255) null,
    statut            int null,
    quantite          int       default 1,
    id_user           int null,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP table if exists client_messages;
create table client_messages
(
    id_clientmessage int primary key AUTO_INCREMENT,
    id_client        int not null,
    id_message       int not null,
    id_user          int null,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP table if exists abonnements;
create table abonnements
(
    `id_abonnement`   bigint(20) primary key AUTO_INCREMENT,
    `id_client`         int(11) NOT NULL,
    `id_decodeur`       int(11) NOT NULL,
    `id_formule`        int(11) NOT NULL,
    `type_abonnement`   int(11) NOT NULL,
    `date_reabonnement` date NOT NULL,
    `date_echeance` date  NULL,
    `statut_abo`      int not  NULL,
    `duree`      int not  NULL,
    `id_user`           int(11) NOT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP table if exists upgrades;
create table upgrades
(
    `id_upgrade`   bigint(20) primary key AUTO_INCREMENT,
    `id_oldformule`        int(11) NOT NULL,
    `id_newformule`        int(11) NOT NULL,
    `montant_upgrade`        float NOT NULL,
    `type_upgrade`  int(11) NOT NULL,
    `date_upgrade`  date NULL,
    `statut_upgrade`  int not NULL,
    `id_reabonnement` int null ,
    `id_abonnement` int null ,
    `id_user`           int(11) NOT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP table if exists type_operations;
create table type_operations
(
    `id_type`   bigint(20) primary key AUTO_INCREMENT,
    `operation`  varchar(50) NULL,
    `type`  int(11) NOT NULL,
    `id_reabonnement`  int(11)  NULL,
    `id_abonnement`  int(11)  NULL,
    `id_upgrade`  int(11)  NULL,
    `date_ajout`  date ,
    `montant`  float ,
    `id_user`           int(11) NOT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



ALTER table client_decodeurs
    add column num_abonne varchar(100) null;

ALTER table reabonnements
    add column `date_echeance` date NULL;

ALTER table reabonnements
    add column `statut_reabo` int NULL;


ALTER table caisses
    add column raison varchar(100) null;

ALTER table caisses
    add column id_abonnement int null;
ALTER table caisses
    add column id_reabonnement int null;
ALTER table caisses
    add column id_upgrade int null;
ALTER table caisses
    add column id_achat int null;
ALTER table caisses
    add column id_materiel int null;
ALTER table caisses
    add column id_decodeur int null;
ALTER table caisses
    add column id_versement int null;
ALTER TABLE `caisses` ADD `type` INT NOT NULL DEFAULT '0' AFTER `raison`;

DROP table if exists stocks;
create table stocks
(
    `id_stock`   bigint(20) primary key AUTO_INCREMENT,
    `code_stock`  varchar(20) not nulls ,
    `prix_unit`  float not null ,
    `date_ajout`  date not null ,
    `statut`  int default 0,
    `id_user`           int(11) NOT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `versement_achats` ADD `quantite` INT NOT NULL  AFTER `montant_achat`;
ALTER TABLE `versement_achats` ADD `date_appro` date NOT NULL  AFTER `quantite`;
