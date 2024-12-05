-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-12-06 02:11:22
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `123456789`
--

-- --------------------------------------------------------

--
-- 表的结构 `emailcode`
--

CREATE TABLE `emailcode` (
  `code` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gonggao`
--

CREATE TABLE `gonggao` (
  `goggao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `gonggao`
--

INSERT INTO `gonggao` (`goggao`) VALUES
('我们建议试用免费服务后，确保服务质量能满足您的需求后再购买<br>\r\n注意：进入假日高峰，部分节点将负载过高，我们将尽量解决问题<br>\r\n不允许搭建传输量大的个人网盘服务，一旦发现，永久封禁\r\n<div class=\"alert alert-primary\" role=\"alert\">\r\n HeloFrp V4.1已经上线，取消了之前的卡密方式与启动器方式,改用全新的使用方式<hr>如果您是之前个人版的用户，如果没有到期，请加入官方qq群聊，凭支付详情，进行补充\r\n</div>');

-- --------------------------------------------------------

--
-- 表的结构 `paidusers`
--

CREATE TABLE `paidusers` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `permissions` varchar(10) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `register`
--

CREATE TABLE `register` (
  `id` varchar(25) NOT NULL,
  `username` varchar(40) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `sf` text NOT NULL,
  `icon` text NOT NULL,
  `gold` varchar(100) NOT NULL,
  `nicheng` varchar(11) NOT NULL,
  `jianjie` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `server`
--

CREATE TABLE `server` (
  `id` varchar(255) NOT NULL,
  `sevname` varchar(20) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `permissions` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `port` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `server`
--

INSERT INTO `server` (`id`, `sevname`, `ip`, `permissions`, `description`, `port`) VALUES
('1', '测试', '1.1.1.1', 'u', '测试', '7000');

--
-- 转储表的索引
--

--
-- 表的索引 `gonggao`
--
ALTER TABLE `gonggao`
  ADD PRIMARY KEY (`goggao`);

--
-- 表的索引 `paidusers`
--
ALTER TABLE `paidusers`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 表的索引 `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`mail`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- 表的索引 `server`
--
ALTER TABLE `server`
  ADD UNIQUE KEY `ip` (`ip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
