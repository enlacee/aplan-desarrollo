
insert into mb_sku( Item, ItemTipo, Linea, Familia, SubFamilia, CaracteristicaValor04, Estado ) values
 ( '0001AC', 'PT', '13', 'BOL', '000', '', 'I' ),
 ( '0001MDCRNUN', 'ME', '01', 'MED', '000', 'I11', 'I' ),
 ( '0003CSHUELA', 'ME', '01', '005', '003', 'V10', 'I' ),
 ( '0003CSHUEME', 'ME', '01', '005', '003', 'V10', 'I' ),
 ( '0004ACCLH', 'PG', '11', 'COS', '000', 'TT', 'A' );

create table mb_grupo_temporada_detalle (
    Codigo int unsigned not null auto_increment,
    CodigoGrupo int unsigned not null,
    CodigoTemporada int unsigned not null,
    primary key(Codigo),
    foreign key(CodigoGrupo) references mb_grupo_temporada(Codigo),
    foreign key(CodigoTemporada) references mb_temporada(Codigo)
) engine=InnoDB;
