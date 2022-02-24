DROP DATABASE IF EXISTS bd_extraescolares;
CREATE DATABASE bd_extraescolares;

CREATE TABLE departamento (
	id_departamento INT AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(10) NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    extension VARCHAR(12) NOT NULL
);

CREATE TABLE responsable (
	id_responsable INT AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(10) NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) NOT NULL
);

CREATE TABLE departamento_responsable (
	id_departamento INT NOT NULL,
    id_responsable INT NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
    FOREIGN KEY (id_responsable) REFERENCES responsable(id_responsable)
);

CREATE TABLE programa (
	id_programa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(150),
    observaciones VARCHAR(150)
);

CREATE TABLE departamento_programa (
	id_departamento INT NOT NULL,
    id_programa INT NOT NULL,
    FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
    FOREIGN KEY (id_programa) REFERENCES programa(id_programa)
);

CREATE TABLE periodo (
	id_periodo INT AUTO_INCREMENT PRIMARY KEY,
    fecha_inicio_actividades DATE NOT NULL,
    fecha_fin_actividades DATE NOT NULL,
    fecha_inicio_inscripciones DATE NOT NULL,
    fecha_fin_inscripciones DATE NOT NULL,
    CONSTRAINT chk_fecha CHECK ((fecha_inicio_actividades < fecha_fin_actividades) AND (fecha_inicio_inscripciones < fecha_fin_inscripciones) AND (fecha_inicio_inscripciones > fecha_inicio_actividades) AND fecha_fin_inscripciones < fecha_fin_actividades)
);