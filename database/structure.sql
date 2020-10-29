CREATE TABLE Mex_CPs (
    mex_cp_id int(16) unsigned AUTO_INCREMENT,
    d_codigo varchar(255),
    d_asenta varchar(255),
    d_tipo_asenta varchar(255),
    d_mnpio varchar(255),
    d_estado varchar(255),
    d_ciudad varchar(255),
    d_CP varchar(255),
    c_estado varchar(16),
    c_oficina varchar(255),
    c_CP varchar(16),
    c_tipo_asenta varchar(16),
    c_mnpio varchar(16),
    id_asenta_cpcons varchar(16),
    d_zona varchar(255),
    c_cve_ciudad varchar(16),
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (mex_cp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


--d_codigo,d_asenta,d_tipo_asenta,d_mnpio,d_estado,d_ciudad,d_CP,c_estado,c_oficina,c_CP,c_tipo_asenta,c_mnpio,id_asenta_cpcons,d_zona,c_cve_ciudad
