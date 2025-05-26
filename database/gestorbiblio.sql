DROP TABLE IF EXISTS `Assunto`;

CREATE TABLE `Assunto` (
    `CodAs` int NOT NULL AUTO_INCREMENT,
    `Descricao` varchar(20) DEFAULT NULL,
    PRIMARY KEY (`CodAs`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Autor`;

CREATE TABLE `Autor` (
    `CodAu` int NOT NULL AUTO_INCREMENT,
    `Nome` varchar(40) DEFAULT NULL,
    PRIMARY KEY (`CodAu`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Livro`;

CREATE TABLE `Livro` (
    `CodL` int NOT NULL AUTO_INCREMENT,
    `Titulo` varchar(40) DEFAULT NULL,
    `Editora` varchar(40) DEFAULT NULL,
    `Edicao` int DEFAULT NULL,
    `AnoPublicacao` varchar(4) DEFAULT NULL,
    `Preco` float DEFAULT NULL,
    PRIMARY KEY (`CodL`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Livro_Assunto`;

CREATE TABLE `Livro_Assunto` (
    `Livro_CodL` int NOT NULL,
    `Assunto_CodAs` int NOT NULL,
    KEY `Livro_Assunto_FkIndex1` (`Livro_CodL`),
    KEY `Livro_Assunto_FkIndex2` (`Assunto_CodAs`),
    CONSTRAINT `Livro_Assunto_FkIndex1` FOREIGN KEY (`Livro_CodL`) REFERENCES `Livro` (`CodL`) ON DELETE CASCADE,
    CONSTRAINT `Livro_Assunto_FkIndex2` FOREIGN KEY (`Assunto_CodAs`) REFERENCES `Assunto` (`CodAs`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `Livro_Autor`;

CREATE TABLE `Livro_Autor` (
    `Livro_CodL` int NOT NULL,
    `Autor_CodAu` int NOT NULL,
    KEY `Livro_Autor_FkIndex1` (`Livro_CodL`),
    KEY `Livro_Autor_FkIndex2` (`Autor_CodAu`),
    CONSTRAINT `Livro_Autor_FkIndex1` FOREIGN KEY (`Livro_CodL`) REFERENCES `Livro` (`CodL`) ON DELETE CASCADE,
    CONSTRAINT `Livro_Autor_FkIndex2` FOREIGN KEY (`Autor_CodAu`) REFERENCES `Autor` (`CodAu`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP VIEW IF EXISTS `View_Relatorio_Livros`;

CREATE ALGORITHM=UNDEFINED
DEFINER=`root`@`%` SQL SECURITY DEFINER
VIEW `View_Relatorio_Livros` AS
SELECT
  `Autor`.`Nome` AS `NomeAu`,
  `Livro`.`CodL` AS `CodL`,
  `Livro`.`Titulo` AS `Titulo`,
  GROUP_CONCAT(DISTINCT `Assunto`.`Descricao` ORDER BY `Assunto`.`Descricao` ASC SEPARATOR ', ') AS `Assuntos`
FROM
  (((`Autor`
    JOIN `Livro_Autor` ON (`Livro_Autor`.`Autor_CodAu` = `Autor`.`CodAu`))
    JOIN `Livro` ON (`Livro`.`CodL` = `Livro_Autor`.`Livro_CodL`))
    LEFT JOIN `Livro_Assunto` ON (`Livro_Assunto`.`Livro_CodL` = `Livro`.`CodL`))
    LEFT JOIN `Assunto` ON (`Assunto`.`CodAs` = `Livro_Assunto`.`Assunto_CodAs`)
GROUP BY `NomeAu`,`Livro`.`CodL`,`Livro`.`Titulo`
ORDER BY `NomeAu`,`Livro`.`Titulo`;