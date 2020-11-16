CREATE DATABASE IF NOT EXISTS busquedaempresarial;
USE busquedaempresarial;
CREATE TABLE IF NOT EXISTS documentos(
	id int NOT NULL AUTO_INCREMENT,
    contenido LONGTEXT,
    PRIMARY KEY(id)
);
ALTER TABLE documentos ADD FULLTEXT (contenido);