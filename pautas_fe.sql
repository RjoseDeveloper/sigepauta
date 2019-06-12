/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.5
Source Server Version : 50130
Source Host           : localhost:3307
Source Database       : pautas_fe

Target Server Type    : MYSQL
Target Server Version : 50130
File Encoding         : 65001

Date: 2019-05-21 17:24:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `actividade`
-- ----------------------------
DROP TABLE IF EXISTS `actividade`;
CREATE TABLE `actividade` (
  `idactividade` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `idutilizador` int(11) DEFAULT NULL,
  `idcurso` int(11) NOT NULL,
  `data_added` date DEFAULT NULL,
  PRIMARY KEY (`idactividade`,`idcurso`),
  KEY `idutilizador` (`idutilizador`),
  KEY `idcurso` (`idcurso`),
  CONSTRAINT `actividade_ibfk_1` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `actividade_ibfk_2` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of actividade
-- ----------------------------
INSERT INTO `actividade` VALUES ('1', 'Matriculas Anual', '2019-02-01', '2019-02-28', '3', '30', '2019-02-16');
INSERT INTO `actividade` VALUES ('2', 'Inscricao Exame Normal', '2019-01-30', '2019-02-28', '3', '30', '2019-02-28');

-- ----------------------------
-- Table structure for `aluno`
-- ----------------------------
DROP TABLE IF EXISTS `aluno`;
CREATE TABLE `aluno` (
  `idaluno` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `bi_recibo` varchar(255) DEFAULT NULL,
  `idnivelescolar` int(255) DEFAULT NULL,
  `iddistrito` int(11) DEFAULT NULL,
  `idendereco` int(11) DEFAULT NULL,
  `idestadocivil` int(11) DEFAULT NULL,
  `docenca_freq` varchar(255) DEFAULT NULL,
  `alergia` varchar(255) DEFAULT NULL,
  `notas` text,
  `data_nascimento` date DEFAULT NULL,
  `nr_mec` varchar(255) DEFAULT NULL,
  `idutilizador` int(11) DEFAULT NULL,
  `data_ingresso` date DEFAULT NULL,
  PRIMARY KEY (`idaluno`),
  KEY `iddistrito` (`iddistrito`),
  KEY `idnivelescolar` (`idnivelescolar`),
  KEY `idendereco` (`idendereco`),
  KEY `idestadocivil` (`idestadocivil`),
  KEY `idutililizador` (`idutilizador`),
  CONSTRAINT `aluno_ibfk_3` FOREIGN KEY (`iddistrito`) REFERENCES `distrito` (`iddistrito`),
  CONSTRAINT `aluno_ibfk_4` FOREIGN KEY (`idnivelescolar`) REFERENCES `nivelescolar` (`idnivel`),
  CONSTRAINT `aluno_ibfk_5` FOREIGN KEY (`idendereco`) REFERENCES `endereco` (`idendereco`),
  CONSTRAINT `aluno_ibfk_6` FOREIGN KEY (`idestadocivil`) REFERENCES `estado_civil` (`idestadocivil`),
  CONSTRAINT `aluno_ibfk_7` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of aluno
-- ----------------------------
INSERT INTO `aluno` VALUES ('1', 'Esmael ', 'Antonio', '16527188B', '1', '1', '1', '1', null, null, null, null, '225', '22', '2019-02-03');
INSERT INTO `aluno` VALUES ('4', 'Celestino', 'Sonia', '21434324', '7', '9', '8', '1', 'Malaria', 'rrrrrrrrrrrrrrr', 'e3erer', '2018-12-03', '227', '23', '2019-02-03');
INSERT INTO `aluno` VALUES ('5', 'Joa', 'Saleme', '12435678', '2', '31', '3', '3', 'wdsd', 'dsD', 'sdsd', '2018-12-05', '113', '24', '2019-02-03');
INSERT INTO `aluno` VALUES ('6', 'sasd', 'Jose', '13213214', '8', '2', '4', '1', '3434', '43434', '344434', '2018-12-06', '112', '25', '2019-02-03');
INSERT INTO `aluno` VALUES ('11', 'Jose', 'Raimund', '56565767', '3', '3', '3', '1', 'Malaria', 'aaagagg', 'attarra', '2018-12-07', '118', '26', '2019-02-18');
INSERT INTO `aluno` VALUES ('12', 'Valter      ', 'Jose', '68980870455', '7', '2', '1', '1', '2', '2', '2', '2019-02-03', '234', '27', '2019-02-11');
INSERT INTO `aluno` VALUES ('13', 'Samuel', 'Antonio ', '08829120020', '3', '27', '4', '1', 'rererer', 'forte', 'Tma Quarana', '2019-01-18', '123', '28', '2019-02-07');
INSERT INTO `aluno` VALUES ('14', 'manuel', 'Saide', '0890754213', '6', '2', '4', '1', 'Malaria', 'aisiis', '1sajnsdsdb', '2019-01-10', '3236', '58', '2019-01-18');
INSERT INTO `aluno` VALUES ('15', 'Raimundo', 'Jose', '02019290309', '8', '2', '3', '2', 'Dor de Cabeca', 'Vertins', 'Menos Estudo', '2018-12-12', '3349', '59', '2019-01-18');
INSERT INTO `aluno` VALUES ('16', 'Antonieta Espranca', 'Antono', '01019929939', '7', '2', '2', '1', 'Dor de Cabeca', 'mateiga', 'asdff', '2019-01-15', '3814', '69', '2019-01-18');
INSERT INTO `aluno` VALUES ('19', 'Universidade Lurio', 'Jose', '13213214', '6', '8', '3', '1', 'sasa', 'as', 'as', '2018-12-04', '3212', '72', '2019-01-20');
INSERT INTO `aluno` VALUES ('20', 'Cassimo', 'Duarte', '01929900991S', '7', '12', '1', '1', 'Malaria', 'sdsdd', 'eddss', '2019-02-06', '3469', '84', '2019-02-16');
INSERT INTO `aluno` VALUES ('21', 'Celestino', 'Almeida', '01929292', '5', '2', '3', '3', 'wdsd', 'XZXZX', 'ssaS', '2019-02-06', '3028', '85', '2019-02-19');
INSERT INTO `aluno` VALUES ('22', 'Joaquim', 'Mario ', '13213214', '7', '15', '2', '1', 'rererer', 'Biliazia', 'hhahah', '2019-02-14', '3084', '89', '2019-02-24');
INSERT INTO `aluno` VALUES ('23', 'Manuel Aquimo', 'Marcelina Jose', '81910001a', '6', '14', '2', '2', 'Malaria', 'Maquina', 'auquuqu', '2019-02-14', '3348', '87', '2019-02-24');
INSERT INTO `aluno` VALUES ('24', 'Junir', 'Miguel', '99910', '7', '13', '2', '1', 'Dor de Cabeca', 'wewqe', 'qwwe', '2019-02-13', '3974', '91', '2019-02-28');
INSERT INTO `aluno` VALUES ('25', 'Celestino Saide', 'Almeida', '01882991', '7', '1', '1', '1', 'Malaria', 'Cossega', 'Nao aplicaveis', '2019-04-09', '3756', '92', '2019-04-11');
INSERT INTO `aluno` VALUES ('26', 'Januario', 'Salimo', '0182991', '7', '6', '3', '1', 'Malaria', 'Cossega', 'ffffffffffff', '2019-04-18', '3703', '93', '2019-04-11');
INSERT INTO `aluno` VALUES ('27', 'Grea Simao', 'Mel', '92009911', '7', '23', '8', '1', 'Malaria', 'Cossega', 'outraa', '2019-04-04', '3258', '94', '2019-04-11');
INSERT INTO `aluno` VALUES ('28', 'Jamila', 'Bacar', '89201001', '8', '7', '3', '2', 'Malaria', 'Cossega', 'huuu', '2019-04-25', '3056', '95', '2019-04-12');
INSERT INTO `aluno` VALUES ('29', 'Padre', 'Jessuino Amade', '18900100200A', '8', '10', '2', '1', 'Malaria', 'Cossega', 'AHGGSG', '2019-04-11', '3709', '97', '2019-04-20');

-- ----------------------------
-- Table structure for `anolectivo`
-- ----------------------------
DROP TABLE IF EXISTS `anolectivo`;
CREATE TABLE `anolectivo` (
  `idano` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(255) NOT NULL,
  PRIMARY KEY (`idano`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of anolectivo
-- ----------------------------
INSERT INTO `anolectivo` VALUES ('1', '1º ANO');
INSERT INTO `anolectivo` VALUES ('2', '2º ANO');
INSERT INTO `anolectivo` VALUES ('3', '3º ANO');
INSERT INTO `anolectivo` VALUES ('4', '4º ANO');
INSERT INTO `anolectivo` VALUES ('5', '5º ANO');
INSERT INTO `anolectivo` VALUES ('6', '6º ANO');
INSERT INTO `anolectivo` VALUES ('7', '7º ANO');
INSERT INTO `anolectivo` VALUES ('8', '8º ANO');

-- ----------------------------
-- Table structure for `bolsa`
-- ----------------------------
DROP TABLE IF EXISTS `bolsa`;
CREATE TABLE `bolsa` (
  `idtipobolsa` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtipobolsa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bolsa
-- ----------------------------

-- ----------------------------
-- Table structure for `carga_horaria`
-- ----------------------------
DROP TABLE IF EXISTS `carga_horaria`;
CREATE TABLE `carga_horaria` (
  `idperiodo` int(11) NOT NULL,
  `horas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idperiodo`),
  CONSTRAINT `carga_horaria_ibfk_1` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`idperiodo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of carga_horaria
-- ----------------------------
INSERT INTO `carga_horaria` VALUES ('5', '10h as 16h');

-- ----------------------------
-- Table structure for `curso`
-- ----------------------------
DROP TABLE IF EXISTS `curso`;
CREATE TABLE `curso` (
  `descricao` varchar(255) NOT NULL,
  `idperfil_instituicao` int(11) NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `data_registo` date NOT NULL,
  `idresponsavel` int(11) NOT NULL,
  `idcurso` int(11) NOT NULL AUTO_INCREMENT,
  `qtd_turmas` int(11) NOT NULL,
  `taxa_matricula` double DEFAULT NULL,
  `idperiodo` int(11) DEFAULT NULL,
  `coordenador` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcurso`),
  KEY `idperfil_instituicao` (`idperfil_instituicao`) USING BTREE,
  KEY `idresponsavel` (`idresponsavel`),
  KEY `idperiodo` (`idperiodo`),
  KEY `coordenador` (`coordenador`),
  CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idperfil_instituicao`) REFERENCES `perfil_instituicao` (`idperfil`),
  CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`idresponsavel`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `curso_ibfk_3` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`idperiodo`),
  CONSTRAINT `curso_ibfk_4` FOREIGN KEY (`coordenador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of curso
-- ----------------------------
INSERT INTO `curso` VALUES ('LEI', '1', '002019', '2019-02-15', '71', '30', '4', '1100', '1', '3');
INSERT INTO `curso` VALUES ('LEC', '1', '002019', '2019-02-15', '74', '31', '4', '1100', '1', '74');
INSERT INTO `curso` VALUES ('LEM', '1', '002018', '2019-02-15', '75', '32', '4', '1100', '1', null);
INSERT INTO `curso` VALUES ('LEG', '1', '002019', '2019-02-15', '70', '33', '4', '1100', '1', null);
INSERT INTO `curso` VALUES ('LCB', '4', '002019', '2019-02-21', '67', '34', '2', '111', '1', null);
INSERT INTO `curso` VALUES ('GIS', '1', '002019', '2019-02-28', '10', '35', '1', '30000', '3', null);

-- ----------------------------
-- Table structure for `data_avaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `data_avaliacao`;
CREATE TABLE `data_avaliacao` (
  `dataRealizacao` date DEFAULT NULL,
  `descricaoteste` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `idplano` int(11) NOT NULL,
  `id_data` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_data`),
  KEY `idplano` (`idplano`),
  CONSTRAINT `data_avaliacao_ibfk_1` FOREIGN KEY (`idplano`) REFERENCES `planoavaliacao` (`idplano`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of data_avaliacao
-- ----------------------------
INSERT INTO `data_avaliacao` VALUES ('2019-02-21', 'Mini-Teste-1', '2', '68', '1');
INSERT INTO `data_avaliacao` VALUES ('2019-02-01', 'Teste-1', '1', '72', '7');
INSERT INTO `data_avaliacao` VALUES ('2019-02-28', 'Teste-2', '1', '72', '8');
INSERT INTO `data_avaliacao` VALUES ('2019-02-23', 'Teste-4', '1', '72', '9');
INSERT INTO `data_avaliacao` VALUES ('2019-01-27', 'Teste-1', '1', '73', '10');
INSERT INTO `data_avaliacao` VALUES ('2019-02-21', 'Teste-2', '1', '73', '11');
INSERT INTO `data_avaliacao` VALUES ('2019-02-23', 'Teste-4', '1', '73', '12');
INSERT INTO `data_avaliacao` VALUES ('2019-01-29', 'Teste-1', '2', '74', '13');
INSERT INTO `data_avaliacao` VALUES ('2019-02-28', 'Teste-2', '2', '74', '14');
INSERT INTO `data_avaliacao` VALUES ('2019-05-16', 'Teste-3', '2', '74', '15');
INSERT INTO `data_avaliacao` VALUES ('2019-05-15', 'Mini-Teste-1', '2', '75', '16');
INSERT INTO `data_avaliacao` VALUES ('2019-07-23', 'Trabalho-1', '2', '76', '17');
INSERT INTO `data_avaliacao` VALUES ('2019-02-13', 'Trabalho-1', '2', '77', '18');

-- ----------------------------
-- Table structure for `despesa`
-- ----------------------------
DROP TABLE IF EXISTS `despesa`;
CREATE TABLE `despesa` (
  `iddespesa` int(11) NOT NULL AUTO_INCREMENT,
  `details` varchar(255) DEFAULT NULL,
  `data_reg` date DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `idorcamento` int(11) NOT NULL,
  `idutilizador` int(11) NOT NULL,
  PRIMARY KEY (`iddespesa`,`idorcamento`,`idutilizador`),
  KEY `idorcamento` (`idorcamento`),
  KEY `idutilizador` (`idutilizador`),
  CONSTRAINT `despesa_ibfk_1` FOREIGN KEY (`idorcamento`) REFERENCES `orcamento` (`idorcamneto`),
  CONSTRAINT `despesa_ibfk_2` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of despesa
-- ----------------------------
INSERT INTO `despesa` VALUES ('1', 'Compra de Quadro', '2019-01-24', '1500', '1', '2');
INSERT INTO `despesa` VALUES ('2', 'Compra de Liro', '2019-01-24', '3000', '1', '2');

-- ----------------------------
-- Table structure for `disciplina`
-- ----------------------------
DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE `disciplina` (
  `idDisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `creditos` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `codigo` int(11) NOT NULL,
  `data_registo` date DEFAULT NULL,
  `natureza` varchar(255) DEFAULT NULL,
  `anolectivo` int(11) DEFAULT NULL,
  `idcurso` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDisciplina`),
  KEY `idDisciplina` (`idDisciplina`),
  KEY `anolectivo` (`anolectivo`),
  KEY `idcurso` (`idcurso`),
  CONSTRAINT `disciplina_ibfk_1` FOREIGN KEY (`anolectivo`) REFERENCES `anolectivo` (`idano`),
  CONSTRAINT `disciplina_ibfk_3` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of disciplina
-- ----------------------------
INSERT INTO `disciplina` VALUES ('1', '5', 'Engenharia de Software 2', '123', null, 'Integral', '2', '30');
INSERT INTO `disciplina` VALUES ('2', '4', 'IHC', '73', null, 'Integral', '2', '30');
INSERT INTO `disciplina` VALUES ('3', '5', 'Fisica Quantica', '646', null, 'Modular', '1', '30');
INSERT INTO `disciplina` VALUES ('4', '4', 'Mecanica e Ondas', '56', null, 'Modular', '1', '31');
INSERT INTO `disciplina` VALUES ('5', '6', 'Progrmacao Web', '567', null, 'Modular', '2', '30');
INSERT INTO `disciplina` VALUES ('6', '6', 'POO', '382', null, 'Integral', '3', '30');
INSERT INTO `disciplina` VALUES ('7', '4', 'ALGA', '57', null, 'Modular', '1', '30');
INSERT INTO `disciplina` VALUES ('9', '4', 'Mecanica do Materiais', '856', null, 'Integral', '2', '31');
INSERT INTO `disciplina` VALUES ('10', '4', 'Desenho ', '3939', null, 'Modular', '1', '31');
INSERT INTO `disciplina` VALUES ('13', '6', 'LC', '767', null, null, '3', '30');
INSERT INTO `disciplina` VALUES ('14', '6', 'PL', '453', null, null, '4', '31');
INSERT INTO `disciplina` VALUES ('15', '5', 'LRC', '465', null, null, '3', '30');
INSERT INTO `disciplina` VALUES ('17', '4', 'RC', '3543', null, null, '2', '30');
INSERT INTO `disciplina` VALUES ('18', '3', 'GPI', '133', null, null, '3', '30');
INSERT INTO `disciplina` VALUES ('23', '6', 'Mecanica dos Fluidos', '2018', '2019-01-14', 'Integral', '1', '31');
INSERT INTO `disciplina` VALUES ('24', '5', 'Desenho de Estrutura', '2019', '2019-01-14', 'Modular', '2', '31');
INSERT INTO `disciplina` VALUES ('25', '6', 'SD', '2018', '2019-01-14', 'Modular', '3', '30');
INSERT INTO `disciplina` VALUES ('26', '5', 'Calculo I', '2019', '2019-01-14', 'Laboratorio', '1', '32');
INSERT INTO `disciplina` VALUES ('27', '6', 'RTF', '2019', '2019-02-19', 'Integral', '2', '33');
INSERT INTO `disciplina` VALUES ('28', '6', 'SBD', '2019', '2019-04-13', 'Laboratorio', '2', '30');

-- ----------------------------
-- Table structure for `disciplina_curso`
-- ----------------------------
DROP TABLE IF EXISTS `disciplina_curso`;
CREATE TABLE `disciplina_curso` (
  `iddisciplina` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `idutilizador` int(11) DEFAULT NULL,
  `idcurso` int(11) DEFAULT NULL,
  `posicao` varchar(255) NOT NULL,
  `idturma` int(11) DEFAULT NULL,
  KEY `idutilizador` (`idutilizador`),
  KEY `iddisciplina` (`iddisciplina`) USING BTREE,
  KEY `idcurso` (`idcurso`),
  KEY `idturma` (`idturma`),
  CONSTRAINT `disciplina_curso_ibfk_4` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `disciplina_curso_ibfk_6` FOREIGN KEY (`iddisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `disciplina_curso_ibfk_7` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`),
  CONSTRAINT `disciplina_curso_ibfk_8` FOREIGN KEY (`idturma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of disciplina_curso
-- ----------------------------
INSERT INTO `disciplina_curso` VALUES ('6', '2019-02-15', '67', '30', 'Assistente', '24');
INSERT INTO `disciplina_curso` VALUES ('6', '2019-02-15', '76', '30', 'Convidado', '24');
INSERT INTO `disciplina_curso` VALUES ('15', '2019-02-16', '3', '30', 'Regente', '25');
INSERT INTO `disciplina_curso` VALUES ('17', '2019-02-16', '3', '30', 'Regente', '24');
INSERT INTO `disciplina_curso` VALUES ('17', '2019-02-16', '58', '30', 'Regente', '24');
INSERT INTO `disciplina_curso` VALUES ('15', '2019-02-16', '58', '30', 'Assistente', '25');
INSERT INTO `disciplina_curso` VALUES ('5', '2019-02-16', '76', '30', 'Regente', '25');
INSERT INTO `disciplina_curso` VALUES ('25', '2019-02-16', '71', '30', 'Regente', '25');
INSERT INTO `disciplina_curso` VALUES ('2', '2019-02-16', '10', '30', 'Regente', '24');
INSERT INTO `disciplina_curso` VALUES ('1', '2019-02-16', '10', '30', 'Assistente', '24');
INSERT INTO `disciplina_curso` VALUES ('15', '2019-02-21', '9', '30', 'Regente', '24');
INSERT INTO `disciplina_curso` VALUES ('18', '2019-02-28', '90', '31', 'Regente', '29');
INSERT INTO `disciplina_curso` VALUES ('1', '2019-04-13', '96', '30', 'Regente', '24');
INSERT INTO `disciplina_curso` VALUES ('18', '2019-04-13', '96', '30', 'Regente', '24');

-- ----------------------------
-- Table structure for `distrito`
-- ----------------------------
DROP TABLE IF EXISTS `distrito`;
CREATE TABLE `distrito` (
  `iddistrito` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `idprovincia` int(11) NOT NULL,
  PRIMARY KEY (`iddistrito`),
  KEY `idprovincia` (`idprovincia`),
  CONSTRAINT `distrito_ibfk_1` FOREIGN KEY (`idprovincia`) REFERENCES `provincia` (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of distrito
-- ----------------------------
INSERT INTO `distrito` VALUES ('1', 'Balama', '1');
INSERT INTO `distrito` VALUES ('2', 'Montepuez', '1');
INSERT INTO `distrito` VALUES ('3', 'Namuno', '1');
INSERT INTO `distrito` VALUES ('4', 'Nangade', '1');
INSERT INTO `distrito` VALUES ('5', 'Ilha de Mocambique', '3');
INSERT INTO `distrito` VALUES ('6', 'Angoche', '3');
INSERT INTO `distrito` VALUES ('7', 'Chiure', '1');
INSERT INTO `distrito` VALUES ('8', 'Metuge', '1');
INSERT INTO `distrito` VALUES ('9', 'Ilha de Ibo', '1');
INSERT INTO `distrito` VALUES ('10', 'Quissanga', '1');
INSERT INTO `distrito` VALUES ('11', 'Macomia', '1');
INSERT INTO `distrito` VALUES ('12', 'Palma', '1');
INSERT INTO `distrito` VALUES ('13', 'Mueda', '1');
INSERT INTO `distrito` VALUES ('14', 'Mocimboa da Praia', '1');
INSERT INTO `distrito` VALUES ('15', 'Pemba', '1');
INSERT INTO `distrito` VALUES ('16', 'Erati', '3');
INSERT INTO `distrito` VALUES ('17', 'Lalaua', '3');
INSERT INTO `distrito` VALUES ('18', 'Larde', '3');
INSERT INTO `distrito` VALUES ('19', 'Liupo', '3');
INSERT INTO `distrito` VALUES ('20', 'Malema', '3');
INSERT INTO `distrito` VALUES ('21', 'Meconta', '3');
INSERT INTO `distrito` VALUES ('22', 'Mecuburi', '3');
INSERT INTO `distrito` VALUES ('23', 'Memba', '3');
INSERT INTO `distrito` VALUES ('24', 'Mogincual', '3');
INSERT INTO `distrito` VALUES ('25', 'Mogovolas', '3');
INSERT INTO `distrito` VALUES ('26', 'Moma', '3');
INSERT INTO `distrito` VALUES ('27', 'Monapo', '3');
INSERT INTO `distrito` VALUES ('28', 'Muecate', '3');
INSERT INTO `distrito` VALUES ('29', 'Marrupula', '3');
INSERT INTO `distrito` VALUES ('30', 'Nacala a Velha', '3');
INSERT INTO `distrito` VALUES ('31', 'Nacala Porto', '3');
INSERT INTO `distrito` VALUES ('32', 'Nacaroa', '3');
INSERT INTO `distrito` VALUES ('33', 'Nampula', '3');
INSERT INTO `distrito` VALUES ('34', 'Rapale', '3');
INSERT INTO `distrito` VALUES ('35', 'Ribaue', '3');
INSERT INTO `distrito` VALUES ('36', 'Chimbonila', '2');
INSERT INTO `distrito` VALUES ('37', 'Cuamba', '2');
INSERT INTO `distrito` VALUES ('38', 'Lago', '2');
INSERT INTO `distrito` VALUES ('39', 'Lichinga', '2');
INSERT INTO `distrito` VALUES ('40', 'Majune', '2');
INSERT INTO `distrito` VALUES ('41', 'Marrupa', '2');
INSERT INTO `distrito` VALUES ('42', 'Maua', '2');
INSERT INTO `distrito` VALUES ('43', 'Mecula', '2');
INSERT INTO `distrito` VALUES ('44', 'Metarica', '2');
INSERT INTO `distrito` VALUES ('45', 'Muembe', '2');
INSERT INTO `distrito` VALUES ('46', 'N`gauma', '2');
INSERT INTO `distrito` VALUES ('47', 'Sanga', '2');
INSERT INTO `distrito` VALUES ('48', 'Nipepe', '2');

-- ----------------------------
-- Table structure for `encarregado_educacao`
-- ----------------------------
DROP TABLE IF EXISTS `encarregado_educacao`;
CREATE TABLE `encarregado_educacao` (
  `idencarregado` int(111) NOT NULL AUTO_INCREMENT,
  `idlocaltrabalho` int(255) DEFAULT NULL,
  `idpessoa` int(111) DEFAULT NULL,
  `nrdocumento` varchar(255) DEFAULT NULL,
  `nivel_escolar` int(11) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `parentesco` varchar(255) DEFAULT NULL,
  `nomeCompleto` varchar(255) NOT NULL,
  PRIMARY KEY (`idencarregado`),
  KEY `idlocaltrabalho` (`idlocaltrabalho`),
  KEY `idEstudante` (`idpessoa`),
  KEY `nivel_escolar` (`nivel_escolar`),
  CONSTRAINT `encarregado_educacao_ibfk_1` FOREIGN KEY (`idlocaltrabalho`) REFERENCES `localtrabalho` (`idlocaltrabalho`),
  CONSTRAINT `encarregado_educacao_ibfk_3` FOREIGN KEY (`nivel_escolar`) REFERENCES `nivelescolar` (`idnivel`),
  CONSTRAINT `encarregado_educacao_ibfk_4` FOREIGN KEY (`idpessoa`) REFERENCES `aluno` (`idaluno`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of encarregado_educacao
-- ----------------------------
INSERT INTO `encarregado_educacao` VALUES ('1', '1', '1', '12435678', '5', '68768798', '34', 'irmao', '');
INSERT INTO `encarregado_educacao` VALUES ('2', '1', '5', '02019028300129A', '9', '68768798', '76', 'adasd', '');
INSERT INTO `encarregado_educacao` VALUES ('3', '2', '4', '13213214', '8', '849018210', '34', 'Pai', '');
INSERT INTO `encarregado_educacao` VALUES ('5', '2', '15', '01929900991S', '7', '849018210', '12', 'irmao', '');
INSERT INTO `encarregado_educacao` VALUES ('6', '1', '14', '00010', '4', '19100', '12', 'Pai', 'Januario Amade');
INSERT INTO `encarregado_educacao` VALUES ('11', '1', '16', '0109192', '6', '', '0', 'Pai', 'Antonio Cabral Jaime');
INSERT INTO `encarregado_educacao` VALUES ('12', '2', '19', '1010012', '8', '', '0', 'Pai', 'Sameul Ambrozio');
INSERT INTO `encarregado_educacao` VALUES ('13', '2', '20', '0109192', '6', '', '0', 'Pai', 'Duarte Jamal');
INSERT INTO `encarregado_educacao` VALUES ('14', '2', '21', '102299', '3', '', '0', 'Pai', 'Celesftino Saie');
INSERT INTO `encarregado_educacao` VALUES ('15', '2', '22', '1829100', '7', '', '0', 'adasd', 'Jonas Balamade');

-- ----------------------------
-- Table structure for `endereco`
-- ----------------------------
DROP TABLE IF EXISTS `endereco`;
CREATE TABLE `endereco` (
  `idendereco` int(11) NOT NULL AUTO_INCREMENT,
  `bairro` varchar(255) DEFAULT NULL,
  `avenida` varchar(255) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `nr_casa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idendereco`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of endereco
-- ----------------------------
INSERT INTO `endereco` VALUES ('1', 'Natite', null, null, null);
INSERT INTO `endereco` VALUES ('2', 'Exapnsao I', null, null, null);
INSERT INTO `endereco` VALUES ('3', 'Expansao II', null, null, null);
INSERT INTO `endereco` VALUES ('4', 'Expansao III', null, null, null);
INSERT INTO `endereco` VALUES ('5', 'Ingonane', null, null, null);
INSERT INTO `endereco` VALUES ('6', 'Bairro Cimento', null, null, null);
INSERT INTO `endereco` VALUES ('7', 'Cariaco', null, null, null);
INSERT INTO `endereco` VALUES ('8', 'Eduardo Mondlane', null, null, null);
INSERT INTO `endereco` VALUES ('9', 'Maringanha', null, null, null);
INSERT INTO `endereco` VALUES ('10', 'Chuiba', null, null, null);
INSERT INTO `endereco` VALUES ('11', 'Muxara', null, null, null);
INSERT INTO `endereco` VALUES ('12', 'Mahate', null, null, null);
INSERT INTO `endereco` VALUES ('13', 'Paquite', null, null, null);

-- ----------------------------
-- Table structure for `estado_civil`
-- ----------------------------
DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `idestadocivil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idestadocivil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estado_civil
-- ----------------------------
INSERT INTO `estado_civil` VALUES ('1', 'Solteiro(a)');
INSERT INTO `estado_civil` VALUES ('2', 'Casado(a)');
INSERT INTO `estado_civil` VALUES ('3', 'Viuvo(a)');
INSERT INTO `estado_civil` VALUES ('4', 'NOTE');

-- ----------------------------
-- Table structure for `estudante_inclusao`
-- ----------------------------
DROP TABLE IF EXISTS `estudante_inclusao`;
CREATE TABLE `estudante_inclusao` (
  `avaliacao` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(255) DEFAULT NULL,
  `data_reg` date NOT NULL,
  `nota` double NOT NULL,
  `idpauta` int(11) NOT NULL,
  `codigo_estudante` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idpauta` (`idpauta`),
  CONSTRAINT `estudante_inclusao_ibfk_1` FOREIGN KEY (`idpauta`) REFERENCES `pautanormal` (`idPautaNormal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudante_inclusao
-- ----------------------------

-- ----------------------------
-- Table structure for `estudante_nota`
-- ----------------------------
DROP TABLE IF EXISTS `estudante_nota`;
CREATE TABLE `estudante_nota` (
  `idNota` int(11) NOT NULL AUTO_INCREMENT,
  `idPautaNormal` int(11) NOT NULL,
  `nota` double NOT NULL,
  `idaluno` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`idNota`,`idaluno`),
  KEY `idPautaNormal` (`idPautaNormal`),
  KEY `idaluno` (`idaluno`),
  CONSTRAINT `estudante_nota_ibfk_2` FOREIGN KEY (`idPautaNormal`) REFERENCES `pautanormal` (`idPautaNormal`),
  CONSTRAINT `estudante_nota_ibfk_3` FOREIGN KEY (`idaluno`) REFERENCES `aluno` (`idaluno`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudante_nota
-- ----------------------------
INSERT INTO `estudante_nota` VALUES ('1', '1', '14', '20', null);
INSERT INTO `estudante_nota` VALUES ('2', '2', '1', '16', null);
INSERT INTO `estudante_nota` VALUES ('3', '2', '12', '25', null);
INSERT INTO `estudante_nota` VALUES ('4', '2', '14', '1', null);
INSERT INTO `estudante_nota` VALUES ('5', '2', '-1', '27', null);
INSERT INTO `estudante_nota` VALUES ('6', '2', '16', '19', null);
INSERT INTO `estudante_nota` VALUES ('7', '2', '18', '26', null);
INSERT INTO `estudante_nota` VALUES ('8', '2', '12', '12', null);
INSERT INTO `estudante_nota` VALUES ('9', '2', '11', '22', null);
INSERT INTO `estudante_nota` VALUES ('10', '2', '8.5', '13', null);
INSERT INTO `estudante_nota` VALUES ('11', '2', '1.75', '15', null);
INSERT INTO `estudante_nota` VALUES ('12', '2', '11.25', '6', null);
INSERT INTO `estudante_nota` VALUES ('13', '2', '18', '11', null);
INSERT INTO `estudante_nota` VALUES ('14', '2', '19.5', '5', null);
INSERT INTO `estudante_nota` VALUES ('15', '2', '20', '4', null);
INSERT INTO `estudante_nota` VALUES ('16', '3', '-1', '1', null);
INSERT INTO `estudante_nota` VALUES ('17', '3', '10', '16', null);
INSERT INTO `estudante_nota` VALUES ('18', '3', '19', '25', null);
INSERT INTO `estudante_nota` VALUES ('19', '3', '11', '27', null);
INSERT INTO `estudante_nota` VALUES ('20', '3', '0', '19', null);
INSERT INTO `estudante_nota` VALUES ('21', '3', '13.75', '26', null);
INSERT INTO `estudante_nota` VALUES ('22', '3', '11', '12', null);
INSERT INTO `estudante_nota` VALUES ('23', '3', '10', '22', null);
INSERT INTO `estudante_nota` VALUES ('24', '3', '4.25', '13', null);
INSERT INTO `estudante_nota` VALUES ('25', '3', '11', '15', null);
INSERT INTO `estudante_nota` VALUES ('26', '3', '-1', '6', null);
INSERT INTO `estudante_nota` VALUES ('27', '3', '12', '11', null);
INSERT INTO `estudante_nota` VALUES ('28', '3', '10', '5', null);
INSERT INTO `estudante_nota` VALUES ('29', '3', '16', '4', null);
INSERT INTO `estudante_nota` VALUES ('30', '4', '12', '1', null);
INSERT INTO `estudante_nota` VALUES ('31', '4', '10', '25', null);
INSERT INTO `estudante_nota` VALUES ('32', '4', '12', '27', null);
INSERT INTO `estudante_nota` VALUES ('33', '4', '14', '19', null);
INSERT INTO `estudante_nota` VALUES ('34', '4', '16', '26', null);
INSERT INTO `estudante_nota` VALUES ('35', '4', '19', '12', null);
INSERT INTO `estudante_nota` VALUES ('36', '4', '20', '22', null);
INSERT INTO `estudante_nota` VALUES ('37', '4', '11', '13', null);
INSERT INTO `estudante_nota` VALUES ('38', '4', '18', '15', null);
INSERT INTO `estudante_nota` VALUES ('39', '4', '20', '6', null);
INSERT INTO `estudante_nota` VALUES ('40', '4', '11', '11', null);
INSERT INTO `estudante_nota` VALUES ('41', '4', '14', '5', null);
INSERT INTO `estudante_nota` VALUES ('42', '4', '19', '4', null);
INSERT INTO `estudante_nota` VALUES ('43', '5', '13', '19', null);
INSERT INTO `estudante_nota` VALUES ('44', '6', '12', '25', null);
INSERT INTO `estudante_nota` VALUES ('45', '6', '11', '16', null);
INSERT INTO `estudante_nota` VALUES ('46', '6', '12', '27', null);
INSERT INTO `estudante_nota` VALUES ('47', '6', '14', '1', null);
INSERT INTO `estudante_nota` VALUES ('48', '6', '11', '28', null);
INSERT INTO `estudante_nota` VALUES ('49', '6', '12', '19', null);
INSERT INTO `estudante_nota` VALUES ('50', '6', '10', '26', null);
INSERT INTO `estudante_nota` VALUES ('51', '6', '11', '29', null);
INSERT INTO `estudante_nota` VALUES ('52', '6', '19', '12', null);
INSERT INTO `estudante_nota` VALUES ('53', '6', '1', '22', null);
INSERT INTO `estudante_nota` VALUES ('54', '6', '12', '13', null);
INSERT INTO `estudante_nota` VALUES ('55', '6', '11', '15', null);
INSERT INTO `estudante_nota` VALUES ('56', '6', '16', '6', null);
INSERT INTO `estudante_nota` VALUES ('57', '6', '18', '11', null);
INSERT INTO `estudante_nota` VALUES ('58', '6', '20', '5', null);
INSERT INTO `estudante_nota` VALUES ('59', '6', '2', '4', null);
INSERT INTO `estudante_nota` VALUES ('60', '7', '11', '25', null);
INSERT INTO `estudante_nota` VALUES ('61', '7', '14', '16', null);
INSERT INTO `estudante_nota` VALUES ('62', '7', '18', '1', null);
INSERT INTO `estudante_nota` VALUES ('63', '7', '12', '27', null);
INSERT INTO `estudante_nota` VALUES ('64', '7', '-1', '28', null);
INSERT INTO `estudante_nota` VALUES ('65', '7', '11', '19', null);
INSERT INTO `estudante_nota` VALUES ('66', '7', '18', '26', null);
INSERT INTO `estudante_nota` VALUES ('67', '7', '15', '29', null);
INSERT INTO `estudante_nota` VALUES ('68', '7', '11', '12', null);
INSERT INTO `estudante_nota` VALUES ('69', '7', '19', '22', null);
INSERT INTO `estudante_nota` VALUES ('70', '7', '11', '13', null);
INSERT INTO `estudante_nota` VALUES ('71', '7', '16', '15', null);
INSERT INTO `estudante_nota` VALUES ('72', '7', '20', '6', null);
INSERT INTO `estudante_nota` VALUES ('73', '7', '1', '11', null);
INSERT INTO `estudante_nota` VALUES ('74', '7', '15', '5', null);
INSERT INTO `estudante_nota` VALUES ('75', '7', '12', '4', null);
INSERT INTO `estudante_nota` VALUES ('81', '4', '12', '16', null);

-- ----------------------------
-- Table structure for `funcionario`
-- ----------------------------
DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE `funcionario` (
  `idutilizador` int(11) NOT NULL,
  `desconto` double DEFAULT NULL,
  `idlocaltrabalho` int(11) DEFAULT NULL,
  KEY `idaluno` (`idutilizador`),
  KEY `idtipoinstituicao` (`idlocaltrabalho`),
  CONSTRAINT `funcionario_ibfk_3` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `funcionario_ibfk_4` FOREIGN KEY (`idlocaltrabalho`) REFERENCES `localtrabalho` (`idlocaltrabalho`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of funcionario
-- ----------------------------

-- ----------------------------
-- Table structure for `grau_academico`
-- ----------------------------
DROP TABLE IF EXISTS `grau_academico`;
CREATE TABLE `grau_academico` (
  `idGrau` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idGrau`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grau_academico
-- ----------------------------
INSERT INTO `grau_academico` VALUES ('1', 'Lic.');
INSERT INTO `grau_academico` VALUES ('2', 'Msc.');
INSERT INTO `grau_academico` VALUES ('3', 'PhD.');

-- ----------------------------
-- Table structure for `inscricao`
-- ----------------------------
DROP TABLE IF EXISTS `inscricao`;
CREATE TABLE `inscricao` (
  `idinscricao` int(11) NOT NULL AUTO_INCREMENT,
  `idturma` int(11) NOT NULL,
  `iddisciplina` int(11) DEFAULT NULL,
  `idutilizador` int(11) DEFAULT NULL,
  `data_registo` date DEFAULT NULL,
  `idregime` int(11) NOT NULL,
  `idturno` int(11) NOT NULL,
  `status_exame` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`idinscricao`,`idturma`,`idregime`,`idturno`),
  KEY `idcurso` (`idturma`),
  KEY `iddisciplina` (`iddisciplina`),
  KEY `idutilizador` (`idutilizador`),
  KEY `idregime` (`idregime`),
  KEY `idturno` (`idturno`),
  CONSTRAINT `inscricao_ibfk_2` FOREIGN KEY (`iddisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `inscricao_ibfk_3` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `inscricao_ibfk_4` FOREIGN KEY (`idturma`) REFERENCES `turma` (`idturma`),
  CONSTRAINT `inscricao_ibfk_6` FOREIGN KEY (`idregime`) REFERENCES `regime` (`idregime`),
  CONSTRAINT `inscricao_ibfk_7` FOREIGN KEY (`idturno`) REFERENCES `turno` (`idturno`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of inscricao
-- ----------------------------
INSERT INTO `inscricao` VALUES ('42', '24', '6', '22', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('43', '24', '6', '23', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('44', '24', '6', '24', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('45', '24', '6', '25', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('46', '24', '6', '26', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('47', '24', '6', '27', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('48', '24', '6', '28', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('49', '24', '6', '28', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('50', '24', '6', '40', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('51', '24', '6', '41', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('52', '24', '6', '59', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('53', '24', '6', '64', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('54', '24', '6', '65', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('55', '24', '6', '69', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('56', '24', '6', '72', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('57', '24', '6', '23', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('58', '25', '5', '22', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('59', '23', '26', '22', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('60', '25', '5', '23', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('61', '25', '5', '24', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('62', '25', '5', '25', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('63', '25', '5', '26', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('64', '25', '5', '27', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('65', '25', '5', '28', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('66', '25', '5', '40', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('67', '25', '5', '41', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('68', '25', '5', '64', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('69', '25', '5', '69', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('70', '25', '5', '72', '2019-02-15', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('71', '26', '14', '25', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('72', '25', '6', '59', '2019-02-15', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('73', '25', '25', '84', '2019-02-16', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('74', '25', '15', '84', '2019-02-16', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('75', '25', '18', '84', '2019-02-16', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('76', '27', '10', '85', '2019-02-19', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('77', '24', '17', '83', '2019-02-19', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('78', '24', '17', '82', '2019-02-19', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('79', '24', '17', '72', '2019-02-19', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('80', '23', '3', '87', '2019-02-21', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('81', '24', '26', '89', '2019-02-24', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('82', '24', '6', '89', '2019-02-24', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('83', '23', '23', '80', '2019-02-28', '2', '2', '', '1');
INSERT INTO `inscricao` VALUES ('84', '23', '25', '80', '2019-02-28', '2', '2', '', '1');
INSERT INTO `inscricao` VALUES ('85', '23', '26', '91', '2019-02-28', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('86', '36', '23', '91', '2019-02-28', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('87', '25', '7', '84', '2019-04-11', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('88', '24', '6', '92', '2019-04-11', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('89', '24', '6', '93', '2019-04-11', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('90', '24', '6', '94', '2019-04-11', '1', '1', '', '1');
INSERT INTO `inscricao` VALUES ('91', '25', '5', '84', '2019-04-12', '1', '1', '', '2');
INSERT INTO `inscricao` VALUES ('92', '24', '6', '95', '2019-04-12', '1', '1', null, null);
INSERT INTO `inscricao` VALUES ('93', '24', '17', '95', '2019-04-12', '1', '1', null, null);
INSERT INTO `inscricao` VALUES ('94', '25', '5', '95', '2019-04-12', '1', '1', null, null);
INSERT INTO `inscricao` VALUES ('95', '24', '6', '97', '2019-04-20', '1', '1', null, null);

-- ----------------------------
-- Table structure for `juro`
-- ----------------------------
DROP TABLE IF EXISTS `juro`;
CREATE TABLE `juro` (
  `idjuro` int(11) NOT NULL AUTO_INCREMENT,
  `juro` double DEFAULT NULL,
  PRIMARY KEY (`idjuro`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of juro
-- ----------------------------
INSERT INTO `juro` VALUES ('1', '0');
INSERT INTO `juro` VALUES ('2', '10');
INSERT INTO `juro` VALUES ('3', '20');
INSERT INTO `juro` VALUES ('4', '30');
INSERT INTO `juro` VALUES ('5', '40');
INSERT INTO `juro` VALUES ('6', '50');
INSERT INTO `juro` VALUES ('7', '60');
INSERT INTO `juro` VALUES ('8', '80');
INSERT INTO `juro` VALUES ('9', '100');
INSERT INTO `juro` VALUES ('10', '70');

-- ----------------------------
-- Table structure for `localtrabalho`
-- ----------------------------
DROP TABLE IF EXISTS `localtrabalho`;
CREATE TABLE `localtrabalho` (
  `idlocaltrabalho` int(11) NOT NULL AUTO_INCREMENT,
  `lcwork` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idlocaltrabalho`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of localtrabalho
-- ----------------------------
INSERT INTO `localtrabalho` VALUES ('1', 'Unilurio', null, null);
INSERT INTO `localtrabalho` VALUES ('2', 'ISCTAC', null, null);
INSERT INTO `localtrabalho` VALUES ('3', 'UCM', null, null);
INSERT INTO `localtrabalho` VALUES ('4', 'INEFP', null, null);

-- ----------------------------
-- Table structure for `nivelescolar`
-- ----------------------------
DROP TABLE IF EXISTS `nivelescolar`;
CREATE TABLE `nivelescolar` (
  `idnivel` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idnivel`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of nivelescolar
-- ----------------------------
INSERT INTO `nivelescolar` VALUES ('1', '5ª Classe');
INSERT INTO `nivelescolar` VALUES ('2', '7ª Classe');
INSERT INTO `nivelescolar` VALUES ('3', '8ª Classe');
INSERT INTO `nivelescolar` VALUES ('4', '9ª Classe');
INSERT INTO `nivelescolar` VALUES ('5', '10ª Classe');
INSERT INTO `nivelescolar` VALUES ('6', '11ª Classe');
INSERT INTO `nivelescolar` VALUES ('7', '12ª Classe');
INSERT INTO `nivelescolar` VALUES ('8', 'Licenciatura');
INSERT INTO `nivelescolar` VALUES ('9', 'Mestre (a)');
INSERT INTO `nivelescolar` VALUES ('10', 'PhD');
INSERT INTO `nivelescolar` VALUES ('11', 'SN');

-- ----------------------------
-- Table structure for `orcamento`
-- ----------------------------
DROP TABLE IF EXISTS `orcamento`;
CREATE TABLE `orcamento` (
  `idorcamneto` int(11) NOT NULL AUTO_INCREMENT,
  `valor` double DEFAULT NULL,
  `data_lacamento` date DEFAULT NULL,
  `idutilizador` int(11) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idorcamneto`,`idutilizador`),
  KEY `idutilizador` (`idutilizador`),
  KEY `idorcamneto` (`idorcamneto`),
  CONSTRAINT `orcamento_ibfk_1` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of orcamento
-- ----------------------------
INSERT INTO `orcamento` VALUES ('1', '30000', '2019-01-24', '2', 'Compra de Material Escolar');
INSERT INTO `orcamento` VALUES ('2', '50000', '2019-01-22', '2', 'Compra de Material de Limpeza');

-- ----------------------------
-- Table structure for `pautanormal`
-- ----------------------------
DROP TABLE IF EXISTS `pautanormal`;
CREATE TABLE `pautanormal` (
  `idPautaNormal` int(11) NOT NULL AUTO_INCREMENT,
  `idcurso` int(11) NOT NULL,
  `idDisciplina` int(11) NOT NULL,
  `idTipoAvaliacao` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `dataReg` date NOT NULL,
  `dataPub` date DEFAULT NULL,
  `idsemestre` int(11) DEFAULT NULL,
  `idusers` int(11) NOT NULL,
  PRIMARY KEY (`idPautaNormal`),
  KEY `idcurso` (`idcurso`),
  KEY `idDisciplina` (`idDisciplina`),
  KEY `idTipoAvaliacao` (`idTipoAvaliacao`),
  KEY `idusers` (`idusers`),
  CONSTRAINT `pautanormal_ibfk_2` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`),
  CONSTRAINT `pautanormal_ibfk_4` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`),
  CONSTRAINT `pautanormal_ibfk_5` FOREIGN KEY (`idusers`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `pautanormal_ibfk_6` FOREIGN KEY (`idTipoAvaliacao`) REFERENCES `data_avaliacao` (`id_data`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pautanormal
-- ----------------------------
INSERT INTO `pautanormal` VALUES ('1', '30', '15', '1', '2', '2019-04-07', '2019-04-08', '1', '3');
INSERT INTO `pautanormal` VALUES ('2', '30', '6', '16', '2', '2019-04-11', '2019-04-11', '1', '67');
INSERT INTO `pautanormal` VALUES ('3', '30', '6', '13', '2', '2019-04-11', '2019-04-12', '1', '67');
INSERT INTO `pautanormal` VALUES ('4', '30', '6', '17', '2', '2019-04-12', '2019-04-20', '1', '67');
INSERT INTO `pautanormal` VALUES ('5', '30', '17', '18', '2', '2019-04-12', '2019-04-20', '1', '3');
INSERT INTO `pautanormal` VALUES ('6', '30', '6', '14', '2', '2019-04-20', '2019-04-20', '1', '67');
INSERT INTO `pautanormal` VALUES ('7', '30', '6', '15', '2', '2019-04-20', '2019-04-20', '1', '67');

-- ----------------------------
-- Table structure for `pay_finality`
-- ----------------------------
DROP TABLE IF EXISTS `pay_finality`;
CREATE TABLE `pay_finality` (
  `idfinalidade` int(11) NOT NULL AUTO_INCREMENT,
  `finalidade` varchar(255) DEFAULT NULL,
  `taxa` double NOT NULL,
  PRIMARY KEY (`idfinalidade`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pay_finality
-- ----------------------------
INSERT INTO `pay_finality` VALUES ('1', 'Matriculas Anual', '1100');
INSERT INTO `pay_finality` VALUES ('2', 'Matricula Semestral', '3500');
INSERT INTO `pay_finality` VALUES ('3', 'Matricula Trimestral', '3600');
INSERT INTO `pay_finality` VALUES ('4', 'Inscricao Disciplina', '600');
INSERT INTO `pay_finality` VALUES ('5', 'Inscricao Exame Normal', '0');
INSERT INTO `pay_finality` VALUES ('6', 'Inscricao Exame Especial', '6000');
INSERT INTO `pay_finality` VALUES ('7', 'Inscricao Exame Extraordinario', '6000');
INSERT INTO `pay_finality` VALUES ('8', 'Inscricao Exame de Recorrencia', '700');

-- ----------------------------
-- Table structure for `perfil_instituicao`
-- ----------------------------
DROP TABLE IF EXISTS `perfil_instituicao`;
CREATE TABLE `perfil_instituicao` (
  `idperfil` int(11) NOT NULL AUTO_INCREMENT,
  `idutilizador_resp` int(11) DEFAULT NULL,
  `nome_instituicao` varchar(255) DEFAULT NULL,
  `data_registo` date DEFAULT NULL,
  `idendereco` int(11) DEFAULT NULL,
  `nome2instituicao` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `codigopostal` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dirpedagogico` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `nuit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idperfil`),
  KEY `idutilizador_resp` (`idutilizador_resp`),
  KEY `idendereco` (`idendereco`),
  CONSTRAINT `perfil_instituicao_ibfk_1` FOREIGN KEY (`idutilizador_resp`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `perfil_instituicao_ibfk_2` FOREIGN KEY (`idendereco`) REFERENCES `endereco` (`idendereco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perfil_instituicao
-- ----------------------------
INSERT INTO `perfil_instituicao` VALUES ('1', '11', 'Faculdade de Engenharia', '2018-09-25', '1', 'Faculdade de Engenharia', '8352167', '995', 'fe@unilurio.ac.mz', 'Miro de Nelio Tucua', 'img/1543785765_Lurio_University_logo.png', 'Cabo Delgado', 'Pemba', '11239405');
INSERT INTO `perfil_instituicao` VALUES ('3', '7', 'Faculdade de Ciencias Naturais', '2018-09-25', '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `perfil_instituicao` VALUES ('4', '3', 'FTGI', '2018-09-25', '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `perfil_instituicao` VALUES ('5', '65', 'INFOSS.NET', '2019-01-14', '3', 'Centro de Informática', '849018210', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `periodo`
-- ----------------------------
DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `idperiodo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idperiodo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of periodo
-- ----------------------------
INSERT INTO `periodo` VALUES ('1', 'Semestral');
INSERT INTO `periodo` VALUES ('2', 'Trimestral');
INSERT INTO `periodo` VALUES ('3', 'Mensal');
INSERT INTO `periodo` VALUES ('4', 'Semanal');
INSERT INTO `periodo` VALUES ('5', 'Por Hora');

-- ----------------------------
-- Table structure for `planoavaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `planoavaliacao`;
CREATE TABLE `planoavaliacao` (
  `idplano` int(11) NOT NULL AUTO_INCREMENT,
  `data_registo` date DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `idTipoAvaliacao` int(11) DEFAULT NULL,
  `idDisciplina` int(11) DEFAULT NULL,
  PRIMARY KEY (`idplano`),
  KEY `idTipoAvaliacao` (`idTipoAvaliacao`),
  KEY `idDisciplina` (`idDisciplina`),
  CONSTRAINT `planoavaliacao_ibfk_1` FOREIGN KEY (`idTipoAvaliacao`) REFERENCES `tipoavaliacao` (`idTipoAvaliacao`),
  CONSTRAINT `planoavaliacao_ibfk_2` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`idDisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of planoavaliacao
-- ----------------------------
INSERT INTO `planoavaliacao` VALUES ('68', '2019-02-13', '20', '2', '15');
INSERT INTO `planoavaliacao` VALUES ('72', '2019-02-13', '70', '1', '25');
INSERT INTO `planoavaliacao` VALUES ('73', '2019-02-13', '70', '1', '17');
INSERT INTO `planoavaliacao` VALUES ('74', '2019-02-15', '80', '1', '6');
INSERT INTO `planoavaliacao` VALUES ('75', '2019-02-15', '80', '2', '6');
INSERT INTO `planoavaliacao` VALUES ('76', '2019-02-15', '10', '3', '6');
INSERT INTO `planoavaliacao` VALUES ('77', '2019-02-28', '20', '3', '17');

-- ----------------------------
-- Table structure for `prestacao`
-- ----------------------------
DROP TABLE IF EXISTS `prestacao`;
CREATE TABLE `prestacao` (
  `valor` double DEFAULT NULL,
  `datapay` date DEFAULT NULL,
  `idjuro` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `modepay` varchar(255) DEFAULT NULL,
  `idfinalidade` int(11) NOT NULL,
  `idcurso` int(11) NOT NULL,
  `idaluno` int(11) NOT NULL,
  `user_session_id` int(11) NOT NULL,
  PRIMARY KEY (`idjuro`,`status`,`idfinalidade`,`idcurso`,`idaluno`),
  KEY `idpagamento` (`idjuro`),
  KEY `idfinalidade` (`idfinalidade`),
  KEY `idcurso` (`idcurso`),
  KEY `idaluno` (`idaluno`),
  KEY `user_session_id` (`user_session_id`),
  KEY `status` (`status`),
  CONSTRAINT `prestacao_ibfk_2` FOREIGN KEY (`idjuro`) REFERENCES `juro` (`idjuro`),
  CONSTRAINT `prestacao_ibfk_4` FOREIGN KEY (`idfinalidade`) REFERENCES `pay_finality` (`idfinalidade`),
  CONSTRAINT `prestacao_ibfk_5` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`),
  CONSTRAINT `prestacao_ibfk_6` FOREIGN KEY (`idaluno`) REFERENCES `aluno` (`idaluno`),
  CONSTRAINT `prestacao_ibfk_7` FOREIGN KEY (`user_session_id`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `prestacao_ibfk_8` FOREIGN KEY (`status`) REFERENCES `status_payments` (`idstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prestacao
-- ----------------------------
INSERT INTO `prestacao` VALUES ('1111', '2019-02-16', '1', '1', 'Cash', '1', '30', '15', '2');
INSERT INTO `prestacao` VALUES ('1111', '2019-02-16', '1', '1', 'Cash', '1', '30', '16', '2');
INSERT INTO `prestacao` VALUES ('3636', '2019-02-16', '1', '1', 'Cash', '2', '30', '15', '2');
INSERT INTO `prestacao` VALUES ('2080', '2019-02-28', '4', '1', 'Cash', '1', '34', '15', '2');

-- ----------------------------
-- Table structure for `previlegio`
-- ----------------------------
DROP TABLE IF EXISTS `previlegio`;
CREATE TABLE `previlegio` (
  `idprevilegio` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  PRIMARY KEY (`idprevilegio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of previlegio
-- ----------------------------
INSERT INTO `previlegio` VALUES ('1', 'Estudante', 'estudante');
INSERT INTO `previlegio` VALUES ('2', 'Docente', 'docente');
INSERT INTO `previlegio` VALUES ('3', 'Director do Curso', 'coordenador');
INSERT INTO `previlegio` VALUES ('4', 'Registo Academico', 'racademico');
INSERT INTO `previlegio` VALUES ('5', 'Director da Faculdade', 'director');
INSERT INTO `previlegio` VALUES ('6', 'Director Adj. Pedagogico', 'dir_adjunto_pedag');
INSERT INTO `previlegio` VALUES ('7', 'Encarregado de Educacao', 'encarregado');

-- ----------------------------
-- Table structure for `professor`
-- ----------------------------
DROP TABLE IF EXISTS `professor`;
CREATE TABLE `professor` (
  `idprofessor` int(211) NOT NULL AUTO_INCREMENT,
  `tempo` varchar(255) DEFAULT NULL,
  `dataregisto` date DEFAULT NULL,
  `idutilizador` int(11) DEFAULT NULL,
  `idgrau` int(11) DEFAULT NULL,
  PRIMARY KEY (`idprofessor`),
  KEY `idutilizador` (`idutilizador`),
  KEY `idgrau` (`idgrau`),
  CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`idgrau`) REFERENCES `grau_academico` (`idGrau`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of professor
-- ----------------------------
INSERT INTO `professor` VALUES ('7', 'Inteiro', '2019-01-13', '67', '1');
INSERT INTO `professor` VALUES ('8', 'Inteiro', '2019-01-13', '2', '1');
INSERT INTO `professor` VALUES ('11', 'Inteiro', '2019-01-14', '70', '1');
INSERT INTO `professor` VALUES ('13', 'Inteiro', '2019-01-19', '4', '1');
INSERT INTO `professor` VALUES ('14', 'Inteiro', '2019-02-06', '11', '2');
INSERT INTO `professor` VALUES ('15', 'Inteiro', '2019-02-06', '3', '2');
INSERT INTO `professor` VALUES ('16', 'Inteiro', '2019-02-06', '58', '1');
INSERT INTO `professor` VALUES ('17', 'Inteiro', '2019-02-12', '73', '2');
INSERT INTO `professor` VALUES ('18', 'Inteiro', '2019-02-16', '76', '1');
INSERT INTO `professor` VALUES ('19', 'Inteiro', '2019-02-16', '71', '2');
INSERT INTO `professor` VALUES ('20', 'Inteiro', '2019-02-16', '10', '2');
INSERT INTO `professor` VALUES ('21', 'Inteiro', '2019-02-21', '9', '2');
INSERT INTO `professor` VALUES ('22', 'Parcial', '2019-02-28', '90', '1');
INSERT INTO `professor` VALUES ('23', 'Inteiro', '2019-04-13', '96', '1');

-- ----------------------------
-- Table structure for `provincia`
-- ----------------------------
DROP TABLE IF EXISTS `provincia`;
CREATE TABLE `provincia` (
  `idprovincia` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of provincia
-- ----------------------------
INSERT INTO `provincia` VALUES ('1', 'Cabo Delgado');
INSERT INTO `provincia` VALUES ('2', 'Niassa');
INSERT INTO `provincia` VALUES ('3', 'Nampula');
INSERT INTO `provincia` VALUES ('4', 'Tete');
INSERT INTO `provincia` VALUES ('5', 'Quelimane');
INSERT INTO `provincia` VALUES ('6', 'Maputo');
INSERT INTO `provincia` VALUES ('7', 'Sofala');
INSERT INTO `provincia` VALUES ('8', 'Zambezia');
INSERT INTO `provincia` VALUES ('9', 'Inhambane');
INSERT INTO `provincia` VALUES ('10', 'Gaza');

-- ----------------------------
-- Table structure for `regime`
-- ----------------------------
DROP TABLE IF EXISTS `regime`;
CREATE TABLE `regime` (
  `idregime` int(111) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idregime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of regime
-- ----------------------------
INSERT INTO `regime` VALUES ('1', 'Presencial');
INSERT INTO `regime` VALUES ('2', 'A distancia');

-- ----------------------------
-- Table structure for `status_payments`
-- ----------------------------
DROP TABLE IF EXISTS `status_payments`;
CREATE TABLE `status_payments` (
  `idstatus` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idstatus`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of status_payments
-- ----------------------------
INSERT INTO `status_payments` VALUES ('1', '-1', 'Dentro do Prazo');
INSERT INTO `status_payments` VALUES ('2', '1', 'Fora do Prazo');
INSERT INTO `status_payments` VALUES ('3', '2', 'Adiantado');
INSERT INTO `status_payments` VALUES ('4', '3', 'Bolseiro');

-- ----------------------------
-- Table structure for `tipoavaliacao`
-- ----------------------------
DROP TABLE IF EXISTS `tipoavaliacao`;
CREATE TABLE `tipoavaliacao` (
  `idTipoAvaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`idTipoAvaliacao`),
  UNIQUE KEY `unique_idTipoAvaliacao` (`idTipoAvaliacao`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipoavaliacao
-- ----------------------------
INSERT INTO `tipoavaliacao` VALUES ('1', 'Teste', '2');
INSERT INTO `tipoavaliacao` VALUES ('2', 'Mini-Teste', '2');
INSERT INTO `tipoavaliacao` VALUES ('3', 'Trabalho', '2');
INSERT INTO `tipoavaliacao` VALUES ('4', 'Exame Normal', '2');
INSERT INTO `tipoavaliacao` VALUES ('5', 'Exame de Recorrencia', '2');
INSERT INTO `tipoavaliacao` VALUES ('6', 'Exame Especial/ExtraOrd', '2');
INSERT INTO `tipoavaliacao` VALUES ('7', 'Exame de Estado', '2');

-- ----------------------------
-- Table structure for `turma`
-- ----------------------------
DROP TABLE IF EXISTS `turma`;
CREATE TABLE `turma` (
  `idturma` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `idcurso` int(11) DEFAULT NULL,
  PRIMARY KEY (`idturma`),
  KEY `idcurso` (`idcurso`),
  CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of turma
-- ----------------------------
INSERT INTO `turma` VALUES ('23', 'Nivel - 1', '30');
INSERT INTO `turma` VALUES ('24', 'Nivel - 2', '30');
INSERT INTO `turma` VALUES ('25', 'Nivel - 3', '30');
INSERT INTO `turma` VALUES ('26', 'Nivel - 4', '30');
INSERT INTO `turma` VALUES ('27', 'Nivel - 1', '31');
INSERT INTO `turma` VALUES ('28', 'Nivel - 2', '31');
INSERT INTO `turma` VALUES ('29', 'Nivel - 3', '31');
INSERT INTO `turma` VALUES ('30', 'Nivel - 4', '31');
INSERT INTO `turma` VALUES ('31', 'Nivel - 1', '32');
INSERT INTO `turma` VALUES ('32', 'Nivel - 2', '32');
INSERT INTO `turma` VALUES ('33', 'Nivel - 3', '32');
INSERT INTO `turma` VALUES ('34', 'Nivel - 4', '32');
INSERT INTO `turma` VALUES ('35', 'Nivel - 1', '33');
INSERT INTO `turma` VALUES ('36', 'Nivel - 2', '33');
INSERT INTO `turma` VALUES ('37', 'Nivel - 3', '33');
INSERT INTO `turma` VALUES ('38', 'Nivel - 4', '33');
INSERT INTO `turma` VALUES ('39', 'Nivel - 1', '34');
INSERT INTO `turma` VALUES ('40', 'Nivel - 2', '34');
INSERT INTO `turma` VALUES ('41', 'Nivel - 1', '35');

-- ----------------------------
-- Table structure for `turno`
-- ----------------------------
DROP TABLE IF EXISTS `turno`;
CREATE TABLE `turno` (
  `idturno` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idturno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of turno
-- ----------------------------
INSERT INTO `turno` VALUES ('1', 'Laboral');
INSERT INTO `turno` VALUES ('2', 'Pos Laboral');

-- ----------------------------
-- Table structure for `utilizador`
-- ----------------------------
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_ingresso` date NOT NULL,
  `idprevilegio` int(11) DEFAULT NULL,
  `nomeCompleto` varchar(255) DEFAULT NULL,
  `estado` int(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `sexo` char(1) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idprevilegio` (`idprevilegio`),
  CONSTRAINT `utilizador_ibfk_2` FOREIGN KEY (`idprevilegio`) REFERENCES `previlegio` (`idprevilegio`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utilizador
-- ----------------------------
INSERT INTO `utilizador` VALUES ('2', 'mauricio.quembo@unilurio.ac.mz', '123', '2011-10-04', '4', 'Mauricio Quembo', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('3', 'miro.tucua@unilurio.ac.mz', '123', '2011-10-04', '6', 'Miro de Nélio Tucua', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('4', 'jose.tafula@unilurio.ac.mz', '123', '2011-10-04', '3', 'Jose Eduardo Tafula', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('5', 'celso.vanimaly@unilurio.ac.mz', '123', '2011-10-04', '3', 'Celso Vanimaly', null, null, null, 'N');
INSERT INTO `utilizador` VALUES ('7', 'heraclito@unilurio.ac.mz', '123', '2011-10-04', '3', 'Heraclito Comia', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('8', 'valeriana@unilurio.ac.mz', '123', '2011-10-04', '2', 'Valeria Jamal', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('9', 'geraldo@unilurio.ac.mz', '123', '2011-10-04', '2', 'Geraldo Filipe', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('10', 'fillermino@unilurio.ac.mz', '123', '2011-10-04', '2', 'Felermino D. Ali', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('11', 'elidio.silva@unilurio.ac.mz', '123', '2011-10-04', '5', 'Elidio Tomas da Silva', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('22', 'emenia@unilurio.ac.mz', '123', '2011-10-04', '1', 'Esmenia Antonio', null, null, null, 'F');
INSERT INTO `utilizador` VALUES ('23', 'valinho@unilurio.ac.mz', '123', '2011-10-04', '1', 'Valinho Antonio', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('24', 'esmael@unilurio.ac.mz', '123', '2011-10-04', '1', 'Valerio Cabral', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('25', 'vabral@unilurio.ac.mz', '123', '2011-10-04', '1', 'Valdimiro Jose', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('26', 'valdimiro@unilurio.ac.mz', '123', '2011-10-04', '1', 'Valdo Tnoas', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('27', 'joana@unilurio.ac.mz', '123', '2011-10-04', '1', 'Joana Ernesto', null, null, null, 'F');
INSERT INTO `utilizador` VALUES ('28', 'nadia@unilurio.ac.mz', '123', '2011-10-04', '1', 'Nadia Pedro', null, null, null, 'F');
INSERT INTO `utilizador` VALUES ('40', 'felix@unilurio.ac.mz', '123', '2011-10-04', '1', 'Felix Cabral', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('41', 'cavaldo@unilurio.ac.mzz', '123', '2011-10-04', '1', 'Cavaldo Ambrosio', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('58', 'saide.saide@unilurio.ac.mz', '123', '2011-10-04', '2', 'Saide Manuel Saide', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('59', 'rjose@unilurio.ac.mz', '123', '2015-04-14', '1', 'Raimundo Jose', null, null, null, 'M');
INSERT INTO `utilizador` VALUES ('64', 'sjofise', '$2y$10$OWZF35hz.u0He6UJGQ1MKejXAFFmP38F6xm/Uif3PA06E9XdYbCLu', '2018-12-02', '1', 'Samuel Jofrise', '11233', 's@gmail.com', '849081891', 'M');
INSERT INTO `utilizador` VALUES ('65', 'sjoaquim', 'rjose1992', '2018-12-02', '1', 'Cabral Joaquim', '11233', 'sj@gmail.com', null, 'M');
INSERT INTO `utilizador` VALUES ('66', 'jjoaoa', 'rjose19928', '2018-12-02', '2', 'Jamal Juvencio Joao', '1', 'jjoao@gmail.com', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('67', 'rjose', '123', '2018-12-02', '2', 'Raimundo Jose', '1', 'raimundo.jose@unilurio.ac.mz', '86172782', 'M');
INSERT INTO `utilizador` VALUES ('68', 'smlaico', '12345678', '2019-01-06', '2', 'Samuel Antonio Malaico', '1', 'smaio@gmail.com', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('69', 'aantonio', '12345678', '2019-01-06', '1', 'Antonieta da Esperanca Antonio', '1', 'antonio@gmail.com', '68768798', 'F');
INSERT INTO `utilizador` VALUES ('70', 'cchaquisse', '12345678', '2019-01-13', '3', 'Claudino Raul Chaquisse', '1', 'claudino.chaquisse@unilurio.ac.mz', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('71', 'lpina', '12345678', '2019-01-15', '3', 'Luis Filipe Pina', '1', 'luis.filipe@unilurio.ac.mz', '8490188210', 'M');
INSERT INTO `utilizador` VALUES ('72', 'jpalasso', '123456', '2019-01-20', '1', 'Januario Palasse', '1', 'jpasso@gmail.com', '8352167', 'M');
INSERT INTO `utilizador` VALUES ('73', 'pj', '123456', '2019-02-12', '2', 'Januraio Pedro', '1', 'pj@uniluriioa.ac.mz', '7262728', 'M');
INSERT INTO `utilizador` VALUES ('74', 'gmulauzi', '12345678', '2019-02-15', '3', 'Gabriel Mulauzi', '1', 'gabriel.mulauzi@unilurio.ac.mz', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('75', 'lmatandires', '12345678', '2019-02-15', '3', 'Lourecno Matandire', '1', 'lourenco.matandire@unilurio.ac.mz', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('76', 'emueva', '123456', '2019-02-15', '2', 'Ussimane M. Mueva', '1', 'ussimane.muieva@unilurio.ac.mz', '8268191991', 'M');
INSERT INTO `utilizador` VALUES ('77', 'gpaluno', '12345678', '2019-02-16', '1', 'greia pau;ino', '1', 'fe@gmail.com', '454545', 'M');
INSERT INTO `utilizador` VALUES ('78', 'tjunior', '123456', '2019-02-16', '1', 'Thandy Junor', '1', 'fe@unilurio.ac.mz', '645645', 'M');
INSERT INTO `utilizador` VALUES ('79', 'dfdsfd', '123456', '2019-02-16', '1', 'efdfdfd', '1', 'fe1@unilurio.ac.mz', '68768798', 'M');
INSERT INTO `utilizador` VALUES ('80', 'jose', '123456', '2019-02-16', '1', 'rosario', '1', 'rjose@yahoo.com', '68768798', 'M');
INSERT INTO `utilizador` VALUES ('81', 'jernesto', '123456', '2019-02-16', '1', 'Joana Ernesto', '1', 'jernesto@unilurio.ac.mz', '8352167', 'F');
INSERT INTO `utilizador` VALUES ('82', 'JJMAL', '123456', '2019-02-16', '1', 'Jamal Juma', '1', 'jjmali@gmail.com', '345467', 'M');
INSERT INTO `utilizador` VALUES ('83', 'randrade', '123456', '2019-02-16', '1', 'Rosario Jose', '1', 'randrade@gmail.com', '86910002', 'M');
INSERT INTO `utilizador` VALUES ('84', 'cduarte', '123', '2019-02-16', '1', 'cassimo duarte', '1', 'cduarte@gmail.com', '8352167', 'M');
INSERT INTO `utilizador` VALUES ('85', 'acelestino', '12345678', '2019-02-19', '1', 'Almeida Celestino', '1', 'almeida.celestino@gmail.com', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('86', 'apatricio', '12345678', '2019-02-19', '1', 'Almerindo Jonas', '1', 'almerindopatricio@unilurio.ac.mz', '84902813', 'M');
INSERT INTO `utilizador` VALUES ('87', 'mjose', '12345678', '2019-02-19', '1', 'Marcelina Jose', '1', 'mjose@unilurio.ac.mz', '84999201', 'F');
INSERT INTO `utilizador` VALUES ('88', 'jgeronimo', '12345678', '2019-02-19', '1', 'Joanita Geronimo', '1', 'jge@unilurio.ac.mz', '8590299200', 'M');
INSERT INTO `utilizador` VALUES ('89', 'mjose@unilurio.ac.mz', '123', '2019-02-19', '1', 'Mario Victor', '1', 'fe@unilurio.ac.mz', '8352167', 'M');
INSERT INTO `utilizador` VALUES ('90', 'fpaulina', '12345678', '2019-02-28', '2', 'Greia Paulino Suamila', '1', 'fe@unilurio.ac.mz', '7181', 'M');
INSERT INTO `utilizador` VALUES ('91', 'mjunior3', '12345678', '2019-02-28', '1', 'Miguel Junior', '1', 'fe@unilurio.ac.mz', '191919', 'M');
INSERT INTO `utilizador` VALUES ('92', 'asaide', '12345678', '2019-04-11', '1', 'Almeida Celestino Saide', '1', 'acelestino@gmail.com', '849018210', 'M');
INSERT INTO `utilizador` VALUES ('93', 'jsalimo', '123456', '2019-04-11', '1', 'Januario Pedro Salimo', '1', 'jsalimo@unilurio.ac.mz', '85902819', 'M');
INSERT INTO `utilizador` VALUES ('94', 'gsimao', '123456', '2019-04-11', '1', 'Greia Simao Mel', '1', 'gsimao@unilurio.ac.mz', '849018829', 'M');
INSERT INTO `utilizador` VALUES ('95', 'jbacar', '123456', '2019-04-12', '1', 'Jamila Bacar', '1', 'jbacar@unilurio.ac.mz', '849009920', 'M');
INSERT INTO `utilizador` VALUES ('96', 'tsuandique', '123456', '2019-04-13', '3', 'Tanira Suandique', '1', 'tanira.suandique@unilurio.ac.mz', '674545', 'F');
INSERT INTO `utilizador` VALUES ('97', 'jmade', '12345678', '2019-04-20', '1', 'Jessuino Amade', '1', 'jamade@unilurio.ac.mz', '849019291', 'M');

-- ----------------------------
-- Table structure for `utilizador_bolsa`
-- ----------------------------
DROP TABLE IF EXISTS `utilizador_bolsa`;
CREATE TABLE `utilizador_bolsa` (
  `idutilizador` int(11) NOT NULL,
  `idtipobolsa` int(11) NOT NULL,
  `idinstituicao` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`idutilizador`,`idtipobolsa`,`idinstituicao`),
  KEY `idtipobolsa` (`idtipobolsa`),
  KEY `idinstituicao` (`idinstituicao`),
  CONSTRAINT `utilizador_bolsa_ibfk_2` FOREIGN KEY (`idtipobolsa`) REFERENCES `bolsa` (`idtipobolsa`),
  CONSTRAINT `utilizador_bolsa_ibfk_3` FOREIGN KEY (`idutilizador`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `utilizador_bolsa_ibfk_4` FOREIGN KEY (`idinstituicao`) REFERENCES `localtrabalho` (`idlocaltrabalho`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utilizador_bolsa
-- ----------------------------
