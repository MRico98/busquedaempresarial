CREATE DATABASE IF NOT EXISTS busquedaempresarial;
USE busquedaempresarial;
CREATE TABLE IF NOT EXISTS documentos(
    nombredocumento varchar(100),
    contenido LONGTEXT,
    PRIMARY KEY(nombredocumento)
);
ALTER TABLE documentos ADD FULLTEXT (contenido);