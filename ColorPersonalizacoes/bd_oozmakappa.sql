-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/10/2019 às 17:57
-- Versão do servidor: 5.7.11-log
-- Versão do PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_oozmakappa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina o código das categorias.',
  `nome` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Informa o nome da categoria.',
  `descricao` text COLLATE utf8_bin COMMENT 'Informa a descrição de cada categoria.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para a definição de categorias dos produtos.';

--
-- Fazendo dump de dados para tabela `categorias`
--

INSERT INTO `categorias` (`codigo`, `nome`, `descricao`) VALUES
(0000000001, 'Escritório', 'Produtos comuns em escritórios.'),
(0000000002, 'Ecológicos', 'Produtos feitos de forma ecológica.'),
(0000000003, 'Festa', 'Produtos utilizados em festas e celebrações.'),
(0000000004, 'Vestuário', 'Produtos com enfoque em vestimentas para os clientes.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina o código do cliente.',
  `nome` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Informa o nome do cliente.',
  `tel1` bigint(11) UNSIGNED NOT NULL COMMENT 'Informa um dos telefones do cliente.',
  `tel2` bigint(11) UNSIGNED DEFAULT NULL COMMENT 'Informa um dos telefones do cliente.',
  `email` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT 'Informa o email do respectivo cliente.',
  `rua` varchar(25) COLLATE utf8_bin NOT NULL COMMENT 'Informa a rua da residência do cliente.',
  `bairro` varchar(30) COLLATE utf8_bin NOT NULL COMMENT 'Informa o bairro da residência do cliente.',
  `cidade` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Informa a cidade da residência do cliente.',
  `numero` int(5) UNSIGNED NOT NULL COMMENT 'Informa o número da residência do cliente.',
  `cpf` bigint(11) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Informa o CPF do cliente.\n',
  `cnpj` bigint(15) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Informa o CNPJ do cliente, caso ele seja empresarial.',
  `estado` char(2) COLLATE utf8_bin NOT NULL COMMENT 'Informa qual o estado da residência do cliente.\nEx.: SC, SP...',
  `cep` int(8) UNSIGNED NOT NULL COMMENT 'Informa o CEP da residência do cliente.',
  `inscricao_estadual` bigint(15) UNSIGNED DEFAULT NULL COMMENT 'Informa a inscrição estadual da residência do cliente, caso for empresarial.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para o registro das informações do cliente.';

--
-- Fazendo dump de dados para tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `tel1`, `tel2`, `email`, `rua`, `bairro`, `cidade`, `numero`, `cpf`, `cnpj`, `estado`, `cep`, `inscricao_estadual`) VALUES
(0000000001, 'Cleuza Ramires', 47988123992, NULL, NULL, 'Rua das Palmeiras', 'Centro', 'Joinville', 45, 48462900000, NULL, 'SC', 89201040, NULL),
(0000000002, 'Empresa Veritas', 1112312312, NULL, 'empresaveritas@gmail.com', 'Rua Três Rios', 'Bom Retiro', 'São Paulo', 353, NULL, 033565054000153, 'SP', 1123000, 862681151536),
(0000000003, 'Carlos Lopes', 55988126743, NULL, 'carloslopes@gmail.com', 'Rua Santos Dummont', 'Bom Retiro', 'Joinville', 479, 77065946029, NULL, 'SC', 89218100, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamentos`
--

CREATE TABLE `orcamentos` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina os códigos dos orçamentos.',
  `parcelas` tinyint(2) UNSIGNED NOT NULL COMMENT 'Informa quantas parcelas o orçamento vai ser feito.\nEx.: 1 - Uma parcela, 4 - Quatro parcelas...',
  `local_entrega` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Informa o local de entrega do produto final.',
  `desconto` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Informa o desconto aplicado no orçamento.',
  `data_emissao` date NOT NULL COMMENT 'Informa a data de emissão do orçamento.',
  `clientes_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Informa o id do cliente da tabela Clientes.',
  `usuarios_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Informa o código do usuário da tabela Usuarios.',
  `status` tinyint(1) DEFAULT NULL COMMENT 'Informa o status da orçamento.\nEx.: 1-Em andamento, 2-Finalizada...\n',
  `valor_total` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Armazena o preço total do orçamento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para a realização dos orçamentos no sistema.';

--
-- Fazendo dump de dados para tabela `orcamentos`
--

INSERT INTO `orcamentos` (`codigo`, `parcelas`, `local_entrega`, `desconto`, `data_emissao`, `clientes_id`, `usuarios_codigo`, `status`) VALUES
(0000000001, 0, 'Rua das Palmeiras, Centro, Joinville, n.45', NULL, '2019-10-29', 0000000001, 0000000003, 1),
(0000000002, 10, 'Rua Três Rios, Bom Retiro, São Paulo, n.353', NULL, '2019-10-29', 0000000002, 0000000001, 1),
(0000000003, 4, 'Santos Dummont, Bom Retiro, Joinville, n.479', NULL, '2019-10-29', 0000000003, 0000000003, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamentos_tem_produtos`
--

CREATE TABLE `orcamentos_tem_produtos` (
  `produtos_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Recebe o código do produto da tabela Produtos',
  `orcamentos_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Recebe o código do orçamento da tabela Orçamentos',
  `preco_atual` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Armazena o preço dos produtos no momento da realização do orçamento.',
  `quantidade` tinyint(3) UNSIGNED NOT NULL COMMENT 'Informa a quantidade de cada produto no orçamento.',
  `especificacao` text COLLATE utf8_bin COMMENT 'Informa a especificação dos produtos no orçamento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar os produtos que vão ter em um orçamento.';

--
-- Fazendo dump de dados para tabela `orcamentos_tem_produtos`
--

INSERT INTO `orcamentos_tem_produtos` (`produtos_codigo`, `orcamentos_codigo`, `preco_atual`, `quantidade`, `especificacao`) VALUES
(0000000002, 0000000003, '12.99', 4, 'Quatro agendas de capa dura com cor preta e estampa do simbolo do Batman em amarelo.'),
(0000000005, 0000000001, '2.50', 35, 'Réguas de plástico rosa com a estampa da personagem Hello Kitty para um aniversário.'),
(0000000015, 0000000002, '6.99', 100, 'Camisas preta com o logo da Empresa Veritas e o ano nas costas abaixo da gola, não muito grande.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordens_de_servicos`
--

CREATE TABLE `ordens_de_servicos` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina o código de uma ordem de serviço.',
  `data_entrega` date NOT NULL COMMENT 'Informa a data de entrega prevista do finalizamento da ordem de serviço.',
  `data_emissao` date NOT NULL COMMENT 'Informa a data de emissão da ordem de serviço.',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT 'Informa o status da ordem de serviço.\nEx.: 1-Em andamento, 2-Finalizada...',
  `orcamentos_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Informa o código do orçamento da tabela Orçamentos.',
  `usuarios_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Informa o código do usuário da tabela Usuarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para a realização de uma ordem de serviço.';

--
-- Fazendo dump de dados para tabela `ordens_de_servicos`
--

INSERT INTO `ordens_de_servicos` (`codigo`, `data_entrega`, `data_emissao`, `status`, `orcamentos_codigo`, `usuarios_codigo`) VALUES
(0000000001, '2019-11-15', '2019-10-29', 1, 0000000001, 0000000004),
(0000000002, '2019-11-26', '2019-10-29', 1, 0000000002, 0000000005),
(0000000003, '2019-11-12', '2019-10-29', 1, 0000000003, 0000000006);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina qual o código do produto',
  `nome` varchar(40) COLLATE utf8_bin NOT NULL COMMENT 'Informa o nome do produto',
  `preco_unitario` decimal(6,2) UNSIGNED NOT NULL COMMENT 'Informa o preço unitário de um produto',
  `descricao` text COLLATE utf8_bin COMMENT 'Apresenta as descrições do produto',
  `categorias_codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Informa o código da categoria da tabela Categorias.',
  `imagem` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Informa o caminho em que a imagem esta guardada no sistema.\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para o armazenamento dos dados dos produtos';

--
-- Fazendo dump de dados para tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `nome`, `preco_unitario`, `descricao`, `categorias_codigo`, `imagem`) VALUES
(0000000001, 'Chaveiro de plástico', '3.90', 'Um chaveiro de plástico customizável.', 0000000001, '15725404905dbb104ac53ff.png'),
(0000000002, 'Agenda capa dura', '12.99', 'Uma agenda de capa dura customizável.', 0000000001, '15725405095dbb105d8bba7.png'),
(0000000003, 'Caneta de plástico ', '3.00', 'Uma caneta de plástico customizável.', 0000000001, '15725405205dbb1068c0491.png'),
(0000000004, 'Squeeze de plástico', '9.90', 'Um squeeze(garrafa) de plástico customizável.', 0000000001, '15725405295dbb107162aaf.png'),
(0000000005, 'Régua de plástico', '2.50', 'Uma régua de plástico customizável.', 0000000001, '15725405465dbb1082b609d.png'),
(0000000006, 'Caderno de capa dura', '9.90', 'Um caderno de capa dura customizável.', 0000000001, '15725405595dbb108f2a340.png'),
(0000000007, 'Caneca de plástico', '5.99', 'Uma caneca de plástico customizável.', 0000000001, '15725405855dbb10a9e4a8b.png'),
(0000000008, 'Lápis', '2.50', 'Um lápis customizável.', 0000000001, '15725405935dbb10b1316fb.png'),
(0000000009, 'Caneta de papelão', '4.00', 'Uma caneta de papelão customizável.', 0000000002, '15725406175dbb10c9b89c9.png'),
(0000000010, 'Agenda de capa de papelão', '16.99', 'Uma agenda com capa de papelão customizável.', 0000000002, '15725406525dbb10ec640f3.png'),
(0000000011, 'Lápis de Eucalipto', '4.50', 'Um lápis de eucalipto customizável', 0000000002, '15725406595dbb10f35bc7b.png'),
(0000000012, 'Taça de plástico cromada', '4.89', 'Uma taça de plástico cromada customizável.', 0000000003, '15725408665dbb11c22667c.png'),
(0000000013, 'Taça de plástico colorida', '3.90', 'Uma taça de plástico colorida customizável.', 0000000003, '15725409015dbb11e5553a1.png'),
(0000000014, 'Camisa polo', '8.00', 'Uma camisa polo customizável.', 0000000004, '15725409235dbb11fb2f0be.png'),
(0000000015, 'Camiseta', '6.99', 'Uma camiseta customizável.', 0000000004, '15725409315dbb12037312c.png'),
(0000000016, 'Boné', '9.90', 'Um boné customizável.', 0000000004, '15725409375dbb12097d24b.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Determina o codigo do usuário',
  `email` varchar(80) COLLATE utf8_bin NOT NULL COMMENT 'Informa o email para o login do usuário.',
  `senha` char(32) COLLATE utf8_bin NOT NULL COMMENT 'Informa a senha para o login do usuário',
  `nivel` tinyint(1) UNSIGNED NOT NULL COMMENT 'Informa o nível que o usuário terá.\nEx.: 1 - Atendente, 2- Estampador, 3-Gerente.',
  `nome_func` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'Informa o nome do funcionário relacionado ao seu usuário.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para a definição dos usuários do site.';

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `email`, `senha`, `nivel`, `nome_func`) VALUES
(0000000001, 'gerente@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 3, 'Gerente'),
(0000000002, 'estampador@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'Estampador'),
(0000000003, 'atendente@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'Atendente'),
(0000000004, 'andredou@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'André Dou'),
(0000000005, 'guilhermofrench@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'Guilhermo French'),
(0000000006, 'henriquerober@color.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 'Henrique Rober');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD UNIQUE KEY `cnpj_UNIQUE` (`cnpj`);

--
-- Índices de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_orcamentos_clientes1_idx` (`clientes_id`),
  ADD KEY `fk_orcamentos_usuarios1_idx` (`usuarios_codigo`);

--
-- Índices de tabela `orcamentos_tem_produtos`
--
ALTER TABLE `orcamentos_tem_produtos`
  ADD PRIMARY KEY (`produtos_codigo`,`orcamentos_codigo`),
  ADD KEY `fk_produtos_has_orcamentos_orcamentos1_idx` (`orcamentos_codigo`),
  ADD KEY `fk_produtos_has_orcamentos_produtos1_idx` (`produtos_codigo`);

--
-- Índices de tabela `ordens_de_servicos`
--
ALTER TABLE `ordens_de_servicos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_ordens_de_servicos_orcamentos_idx` (`orcamentos_codigo`),
  ADD KEY `fk_ordens_de_servicos_usuarios1_idx` (`usuarios_codigo`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_produtos_categorias1_idx` (`categorias_codigo`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina o código das categorias.', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina o código do cliente.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina os códigos dos orçamentos.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `ordens_de_servicos`
--
ALTER TABLE `ordens_de_servicos`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina o código de uma ordem de serviço.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina qual o código do produto', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Determina o codigo do usuário', AUTO_INCREMENT=7;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD CONSTRAINT `fk_orcamentos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orcamentos_usuarios1` FOREIGN KEY (`usuarios_codigo`) REFERENCES `usuarios` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `orcamentos_tem_produtos`
--
ALTER TABLE `orcamentos_tem_produtos`
  ADD CONSTRAINT `fk_produtos_has_orcamentos_orcamentos1` FOREIGN KEY (`orcamentos_codigo`) REFERENCES `orcamentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produtos_has_orcamentos_produtos1` FOREIGN KEY (`produtos_codigo`) REFERENCES `produtos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `ordens_de_servicos`
--
ALTER TABLE `ordens_de_servicos`
  ADD CONSTRAINT `fk_ordens_de_servicos_orcamentos` FOREIGN KEY (`orcamentos_codigo`) REFERENCES `orcamentos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordens_de_servicos_usuarios1` FOREIGN KEY (`usuarios_codigo`) REFERENCES `usuarios` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias1` FOREIGN KEY (`categorias_codigo`) REFERENCES `categorias` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
