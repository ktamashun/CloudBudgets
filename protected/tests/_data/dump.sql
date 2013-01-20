/*
Navicat MySQL Data Transfer

Source Server         : debian
Source Server Version : 50166
Source Host           : debian:3306
Source Database       : cloudbudgets_test

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2013-01-19 22:08:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `initial_balance` double(11,2) NOT NULL DEFAULT '0.00',
  `actual_balance` double(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_account_currency_1` (`currency_id`),
  KEY `fk_account_user_1` (`user_id`),
  KEY `fk_account_account_type_1` (`account_type_id`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`),
  CONSTRAINT `account_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  CONSTRAINT `account_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------

-- ----------------------------
-- Table structure for `account_type`
-- ----------------------------
DROP TABLE IF EXISTS `account_type`;
CREATE TABLE `account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_type
-- ----------------------------
INSERT INTO `account_type` VALUES ('1', 'Cash');
INSERT INTO `account_type` VALUES ('2', 'Checking');
INSERT INTO `account_type` VALUES ('3', 'Credit Card');
INSERT INTO `account_type` VALUES ('4', 'Savings');

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `root` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_user_1` (`user_id`),
  KEY `root` (`root`,`lft`,`rgt`,`level`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `printable_name` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', '4');
INSERT INTO `country` VALUES ('2', 'AL', 'ALBANIA', 'Albania', 'ALB', '8');
INSERT INTO `country` VALUES ('3', 'DZ', 'ALGERIA', 'Algeria', 'DZA', '12');
INSERT INTO `country` VALUES ('4', 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', '16');
INSERT INTO `country` VALUES ('5', 'AD', 'ANDORRA', 'Andorra', 'AND', '20');
INSERT INTO `country` VALUES ('6', 'AO', 'ANGOLA', 'Angola', 'AGO', '24');
INSERT INTO `country` VALUES ('7', 'AI', 'ANGUILLA', 'Anguilla', 'AIA', '660');
INSERT INTO `country` VALUES ('8', 'AQ', 'ANTARCTICA', 'Antarctica', null, null);
INSERT INTO `country` VALUES ('9', 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', '28');
INSERT INTO `country` VALUES ('10', 'AR', 'ARGENTINA', 'Argentina', 'ARG', '32');
INSERT INTO `country` VALUES ('11', 'AM', 'ARMENIA', 'Armenia', 'ARM', '51');
INSERT INTO `country` VALUES ('12', 'AW', 'ARUBA', 'Aruba', 'ABW', '533');
INSERT INTO `country` VALUES ('13', 'AU', 'AUSTRALIA', 'Australia', 'AUS', '36');
INSERT INTO `country` VALUES ('14', 'AT', 'AUSTRIA', 'Austria', 'AUT', '40');
INSERT INTO `country` VALUES ('15', 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', '31');
INSERT INTO `country` VALUES ('16', 'BS', 'BAHAMAS', 'Bahamas', 'BHS', '44');
INSERT INTO `country` VALUES ('17', 'BH', 'BAHRAIN', 'Bahrain', 'BHR', '48');
INSERT INTO `country` VALUES ('18', 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', '50');
INSERT INTO `country` VALUES ('19', 'BB', 'BARBADOS', 'Barbados', 'BRB', '52');
INSERT INTO `country` VALUES ('20', 'BY', 'BELARUS', 'Belarus', 'BLR', '112');
INSERT INTO `country` VALUES ('21', 'BE', 'BELGIUM', 'Belgium', 'BEL', '56');
INSERT INTO `country` VALUES ('22', 'BZ', 'BELIZE', 'Belize', 'BLZ', '84');
INSERT INTO `country` VALUES ('23', 'BJ', 'BENIN', 'Benin', 'BEN', '204');
INSERT INTO `country` VALUES ('24', 'BM', 'BERMUDA', 'Bermuda', 'BMU', '60');
INSERT INTO `country` VALUES ('25', 'BT', 'BHUTAN', 'Bhutan', 'BTN', '64');
INSERT INTO `country` VALUES ('26', 'BO', 'BOLIVIA', 'Bolivia', 'BOL', '68');
INSERT INTO `country` VALUES ('27', 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', '70');
INSERT INTO `country` VALUES ('28', 'BW', 'BOTSWANA', 'Botswana', 'BWA', '72');
INSERT INTO `country` VALUES ('29', 'BV', 'BOUVET ISLAND', 'Bouvet Island', null, null);
INSERT INTO `country` VALUES ('30', 'BR', 'BRAZIL', 'Brazil', 'BRA', '76');
INSERT INTO `country` VALUES ('31', 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', null, null);
INSERT INTO `country` VALUES ('32', 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', '96');
INSERT INTO `country` VALUES ('33', 'BG', 'BULGARIA', 'Bulgaria', 'BGR', '100');
INSERT INTO `country` VALUES ('34', 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', '854');
INSERT INTO `country` VALUES ('35', 'BI', 'BURUNDI', 'Burundi', 'BDI', '108');
INSERT INTO `country` VALUES ('36', 'KH', 'CAMBODIA', 'Cambodia', 'KHM', '116');
INSERT INTO `country` VALUES ('37', 'CM', 'CAMEROON', 'Cameroon', 'CMR', '120');
INSERT INTO `country` VALUES ('38', 'CA', 'CANADA', 'Canada', 'CAN', '124');
INSERT INTO `country` VALUES ('39', 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', '132');
INSERT INTO `country` VALUES ('40', 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', '136');
INSERT INTO `country` VALUES ('41', 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', '140');
INSERT INTO `country` VALUES ('42', 'TD', 'CHAD', 'Chad', 'TCD', '148');
INSERT INTO `country` VALUES ('43', 'CL', 'CHILE', 'Chile', 'CHL', '152');
INSERT INTO `country` VALUES ('44', 'CN', 'CHINA', 'China', 'CHN', '156');
INSERT INTO `country` VALUES ('45', 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', null, null);
INSERT INTO `country` VALUES ('46', 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', null, null);
INSERT INTO `country` VALUES ('47', 'CO', 'COLOMBIA', 'Colombia', 'COL', '170');
INSERT INTO `country` VALUES ('48', 'KM', 'COMOROS', 'Comoros', 'COM', '174');
INSERT INTO `country` VALUES ('49', 'CG', 'CONGO', 'Congo', 'COG', '178');
INSERT INTO `country` VALUES ('50', 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', '180');
INSERT INTO `country` VALUES ('51', 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', '184');
INSERT INTO `country` VALUES ('52', 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', '188');
INSERT INTO `country` VALUES ('53', 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', '384');
INSERT INTO `country` VALUES ('54', 'HR', 'CROATIA', 'Croatia', 'HRV', '191');
INSERT INTO `country` VALUES ('55', 'CU', 'CUBA', 'Cuba', 'CUB', '192');
INSERT INTO `country` VALUES ('56', 'CY', 'CYPRUS', 'Cyprus', 'CYP', '196');
INSERT INTO `country` VALUES ('57', 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', '203');
INSERT INTO `country` VALUES ('58', 'DK', 'DENMARK', 'Denmark', 'DNK', '208');
INSERT INTO `country` VALUES ('59', 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', '262');
INSERT INTO `country` VALUES ('60', 'DM', 'DOMINICA', 'Dominica', 'DMA', '212');
INSERT INTO `country` VALUES ('61', 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', '214');
INSERT INTO `country` VALUES ('62', 'EC', 'ECUADOR', 'Ecuador', 'ECU', '218');
INSERT INTO `country` VALUES ('63', 'EG', 'EGYPT', 'Egypt', 'EGY', '818');
INSERT INTO `country` VALUES ('64', 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', '222');
INSERT INTO `country` VALUES ('65', 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', '226');
INSERT INTO `country` VALUES ('66', 'ER', 'ERITREA', 'Eritrea', 'ERI', '232');
INSERT INTO `country` VALUES ('67', 'EE', 'ESTONIA', 'Estonia', 'EST', '233');
INSERT INTO `country` VALUES ('68', 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', '231');
INSERT INTO `country` VALUES ('69', 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', '238');
INSERT INTO `country` VALUES ('70', 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', '234');
INSERT INTO `country` VALUES ('71', 'FJ', 'FIJI', 'Fiji', 'FJI', '242');
INSERT INTO `country` VALUES ('72', 'FI', 'FINLAND', 'Finland', 'FIN', '246');
INSERT INTO `country` VALUES ('73', 'FR', 'FRANCE', 'France', 'FRA', '250');
INSERT INTO `country` VALUES ('74', 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', '254');
INSERT INTO `country` VALUES ('75', 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', '258');
INSERT INTO `country` VALUES ('76', 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', null, null);
INSERT INTO `country` VALUES ('77', 'GA', 'GABON', 'Gabon', 'GAB', '266');
INSERT INTO `country` VALUES ('78', 'GM', 'GAMBIA', 'Gambia', 'GMB', '270');
INSERT INTO `country` VALUES ('79', 'GE', 'GEORGIA', 'Georgia', 'GEO', '268');
INSERT INTO `country` VALUES ('80', 'DE', 'GERMANY', 'Germany', 'DEU', '276');
INSERT INTO `country` VALUES ('81', 'GH', 'GHANA', 'Ghana', 'GHA', '288');
INSERT INTO `country` VALUES ('82', 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', '292');
INSERT INTO `country` VALUES ('83', 'GR', 'GREECE', 'Greece', 'GRC', '300');
INSERT INTO `country` VALUES ('84', 'GL', 'GREENLAND', 'Greenland', 'GRL', '304');
INSERT INTO `country` VALUES ('85', 'GD', 'GRENADA', 'Grenada', 'GRD', '308');
INSERT INTO `country` VALUES ('86', 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', '312');
INSERT INTO `country` VALUES ('87', 'GU', 'GUAM', 'Guam', 'GUM', '316');
INSERT INTO `country` VALUES ('88', 'GT', 'GUATEMALA', 'Guatemala', 'GTM', '320');
INSERT INTO `country` VALUES ('89', 'GN', 'GUINEA', 'Guinea', 'GIN', '324');
INSERT INTO `country` VALUES ('90', 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', '624');
INSERT INTO `country` VALUES ('91', 'GY', 'GUYANA', 'Guyana', 'GUY', '328');
INSERT INTO `country` VALUES ('92', 'HT', 'HAITI', 'Haiti', 'HTI', '332');
INSERT INTO `country` VALUES ('93', 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', null, null);
INSERT INTO `country` VALUES ('94', 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', '336');
INSERT INTO `country` VALUES ('95', 'HN', 'HONDURAS', 'Honduras', 'HND', '340');
INSERT INTO `country` VALUES ('96', 'HK', 'HONG KONG', 'Hong Kong', 'HKG', '344');
INSERT INTO `country` VALUES ('97', 'HU', 'HUNGARY', 'Hungary', 'HUN', '348');
INSERT INTO `country` VALUES ('98', 'IS', 'ICELAND', 'Iceland', 'ISL', '352');
INSERT INTO `country` VALUES ('99', 'IN', 'INDIA', 'India', 'IND', '356');
INSERT INTO `country` VALUES ('100', 'ID', 'INDONESIA', 'Indonesia', 'IDN', '360');
INSERT INTO `country` VALUES ('101', 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', '364');
INSERT INTO `country` VALUES ('102', 'IQ', 'IRAQ', 'Iraq', 'IRQ', '368');
INSERT INTO `country` VALUES ('103', 'IE', 'IRELAND', 'Ireland', 'IRL', '372');
INSERT INTO `country` VALUES ('104', 'IL', 'ISRAEL', 'Israel', 'ISR', '376');
INSERT INTO `country` VALUES ('105', 'IT', 'ITALY', 'Italy', 'ITA', '380');
INSERT INTO `country` VALUES ('106', 'JM', 'JAMAICA', 'Jamaica', 'JAM', '388');
INSERT INTO `country` VALUES ('107', 'JP', 'JAPAN', 'Japan', 'JPN', '392');
INSERT INTO `country` VALUES ('108', 'JO', 'JORDAN', 'Jordan', 'JOR', '400');
INSERT INTO `country` VALUES ('109', 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', '398');
INSERT INTO `country` VALUES ('110', 'KE', 'KENYA', 'Kenya', 'KEN', '404');
INSERT INTO `country` VALUES ('111', 'KI', 'KIRIBATI', 'Kiribati', 'KIR', '296');
INSERT INTO `country` VALUES ('112', 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', '408');
INSERT INTO `country` VALUES ('113', 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', '410');
INSERT INTO `country` VALUES ('114', 'KW', 'KUWAIT', 'Kuwait', 'KWT', '414');
INSERT INTO `country` VALUES ('115', 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', '417');
INSERT INTO `country` VALUES ('116', 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', '418');
INSERT INTO `country` VALUES ('117', 'LV', 'LATVIA', 'Latvia', 'LVA', '428');
INSERT INTO `country` VALUES ('118', 'LB', 'LEBANON', 'Lebanon', 'LBN', '422');
INSERT INTO `country` VALUES ('119', 'LS', 'LESOTHO', 'Lesotho', 'LSO', '426');
INSERT INTO `country` VALUES ('120', 'LR', 'LIBERIA', 'Liberia', 'LBR', '430');
INSERT INTO `country` VALUES ('121', 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', '434');
INSERT INTO `country` VALUES ('122', 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', '438');
INSERT INTO `country` VALUES ('123', 'LT', 'LITHUANIA', 'Lithuania', 'LTU', '440');
INSERT INTO `country` VALUES ('124', 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', '442');
INSERT INTO `country` VALUES ('125', 'MO', 'MACAO', 'Macao', 'MAC', '446');
INSERT INTO `country` VALUES ('126', 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '807');
INSERT INTO `country` VALUES ('127', 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', '450');
INSERT INTO `country` VALUES ('128', 'MW', 'MALAWI', 'Malawi', 'MWI', '454');
INSERT INTO `country` VALUES ('129', 'MY', 'MALAYSIA', 'Malaysia', 'MYS', '458');
INSERT INTO `country` VALUES ('130', 'MV', 'MALDIVES', 'Maldives', 'MDV', '462');
INSERT INTO `country` VALUES ('131', 'ML', 'MALI', 'Mali', 'MLI', '466');
INSERT INTO `country` VALUES ('132', 'MT', 'MALTA', 'Malta', 'MLT', '470');
INSERT INTO `country` VALUES ('133', 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', '584');
INSERT INTO `country` VALUES ('134', 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', '474');
INSERT INTO `country` VALUES ('135', 'MR', 'MAURITANIA', 'Mauritania', 'MRT', '478');
INSERT INTO `country` VALUES ('136', 'MU', 'MAURITIUS', 'Mauritius', 'MUS', '480');
INSERT INTO `country` VALUES ('137', 'YT', 'MAYOTTE', 'Mayotte', null, null);
INSERT INTO `country` VALUES ('138', 'MX', 'MEXICO', 'Mexico', 'MEX', '484');
INSERT INTO `country` VALUES ('139', 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', '583');
INSERT INTO `country` VALUES ('140', 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', '498');
INSERT INTO `country` VALUES ('141', 'MC', 'MONACO', 'Monaco', 'MCO', '492');
INSERT INTO `country` VALUES ('142', 'MN', 'MONGOLIA', 'Mongolia', 'MNG', '496');
INSERT INTO `country` VALUES ('143', 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', '500');
INSERT INTO `country` VALUES ('144', 'MA', 'MOROCCO', 'Morocco', 'MAR', '504');
INSERT INTO `country` VALUES ('145', 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', '508');
INSERT INTO `country` VALUES ('146', 'MM', 'MYANMAR', 'Myanmar', 'MMR', '104');
INSERT INTO `country` VALUES ('147', 'NA', 'NAMIBIA', 'Namibia', 'NAM', '516');
INSERT INTO `country` VALUES ('148', 'NR', 'NAURU', 'Nauru', 'NRU', '520');
INSERT INTO `country` VALUES ('149', 'NP', 'NEPAL', 'Nepal', 'NPL', '524');
INSERT INTO `country` VALUES ('150', 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', '528');
INSERT INTO `country` VALUES ('151', 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', '530');
INSERT INTO `country` VALUES ('152', 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', '540');
INSERT INTO `country` VALUES ('153', 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', '554');
INSERT INTO `country` VALUES ('154', 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', '558');
INSERT INTO `country` VALUES ('155', 'NE', 'NIGER', 'Niger', 'NER', '562');
INSERT INTO `country` VALUES ('156', 'NG', 'NIGERIA', 'Nigeria', 'NGA', '566');
INSERT INTO `country` VALUES ('157', 'NU', 'NIUE', 'Niue', 'NIU', '570');
INSERT INTO `country` VALUES ('158', 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', '574');
INSERT INTO `country` VALUES ('159', 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', '580');
INSERT INTO `country` VALUES ('160', 'NO', 'NORWAY', 'Norway', 'NOR', '578');
INSERT INTO `country` VALUES ('161', 'OM', 'OMAN', 'Oman', 'OMN', '512');
INSERT INTO `country` VALUES ('162', 'PK', 'PAKISTAN', 'Pakistan', 'PAK', '586');
INSERT INTO `country` VALUES ('163', 'PW', 'PALAU', 'Palau', 'PLW', '585');
INSERT INTO `country` VALUES ('164', 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', null, null);
INSERT INTO `country` VALUES ('165', 'PA', 'PANAMA', 'Panama', 'PAN', '591');
INSERT INTO `country` VALUES ('166', 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', '598');
INSERT INTO `country` VALUES ('167', 'PY', 'PARAGUAY', 'Paraguay', 'PRY', '600');
INSERT INTO `country` VALUES ('168', 'PE', 'PERU', 'Peru', 'PER', '604');
INSERT INTO `country` VALUES ('169', 'PH', 'PHILIPPINES', 'Philippines', 'PHL', '608');
INSERT INTO `country` VALUES ('170', 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', '612');
INSERT INTO `country` VALUES ('171', 'PL', 'POLAND', 'Poland', 'POL', '616');
INSERT INTO `country` VALUES ('172', 'PT', 'PORTUGAL', 'Portugal', 'PRT', '620');
INSERT INTO `country` VALUES ('173', 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', '630');
INSERT INTO `country` VALUES ('174', 'QA', 'QATAR', 'Qatar', 'QAT', '634');
INSERT INTO `country` VALUES ('175', 'RE', 'REUNION', 'Reunion', 'REU', '638');
INSERT INTO `country` VALUES ('176', 'RO', 'ROMANIA', 'Romania', 'ROM', '642');
INSERT INTO `country` VALUES ('177', 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', '643');
INSERT INTO `country` VALUES ('178', 'RW', 'RWANDA', 'Rwanda', 'RWA', '646');
INSERT INTO `country` VALUES ('179', 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', '654');
INSERT INTO `country` VALUES ('180', 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', '659');
INSERT INTO `country` VALUES ('181', 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', '662');
INSERT INTO `country` VALUES ('182', 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', '666');
INSERT INTO `country` VALUES ('183', 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', '670');
INSERT INTO `country` VALUES ('184', 'WS', 'SAMOA', 'Samoa', 'WSM', '882');
INSERT INTO `country` VALUES ('185', 'SM', 'SAN MARINO', 'San Marino', 'SMR', '674');
INSERT INTO `country` VALUES ('186', 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', '678');
INSERT INTO `country` VALUES ('187', 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', '682');
INSERT INTO `country` VALUES ('188', 'SN', 'SENEGAL', 'Senegal', 'SEN', '686');
INSERT INTO `country` VALUES ('189', 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', null, null);
INSERT INTO `country` VALUES ('190', 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', '690');
INSERT INTO `country` VALUES ('191', 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', '694');
INSERT INTO `country` VALUES ('192', 'SG', 'SINGAPORE', 'Singapore', 'SGP', '702');
INSERT INTO `country` VALUES ('193', 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', '703');
INSERT INTO `country` VALUES ('194', 'SI', 'SLOVENIA', 'Slovenia', 'SVN', '705');
INSERT INTO `country` VALUES ('195', 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', '90');
INSERT INTO `country` VALUES ('196', 'SO', 'SOMALIA', 'Somalia', 'SOM', '706');
INSERT INTO `country` VALUES ('197', 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', '710');
INSERT INTO `country` VALUES ('198', 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', null, null);
INSERT INTO `country` VALUES ('199', 'ES', 'SPAIN', 'Spain', 'ESP', '724');
INSERT INTO `country` VALUES ('200', 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', '144');
INSERT INTO `country` VALUES ('201', 'SD', 'SUDAN', 'Sudan', 'SDN', '736');
INSERT INTO `country` VALUES ('202', 'SR', 'SURINAME', 'Suriname', 'SUR', '740');
INSERT INTO `country` VALUES ('203', 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', '744');
INSERT INTO `country` VALUES ('204', 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', '748');
INSERT INTO `country` VALUES ('205', 'SE', 'SWEDEN', 'Sweden', 'SWE', '752');
INSERT INTO `country` VALUES ('206', 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', '756');
INSERT INTO `country` VALUES ('207', 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', '760');
INSERT INTO `country` VALUES ('208', 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', '158');
INSERT INTO `country` VALUES ('209', 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', '762');
INSERT INTO `country` VALUES ('210', 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', '834');
INSERT INTO `country` VALUES ('211', 'TH', 'THAILAND', 'Thailand', 'THA', '764');
INSERT INTO `country` VALUES ('212', 'TL', 'TIMOR-LESTE', 'Timor-Leste', null, null);
INSERT INTO `country` VALUES ('213', 'TG', 'TOGO', 'Togo', 'TGO', '768');
INSERT INTO `country` VALUES ('214', 'TK', 'TOKELAU', 'Tokelau', 'TKL', '772');
INSERT INTO `country` VALUES ('215', 'TO', 'TONGA', 'Tonga', 'TON', '776');
INSERT INTO `country` VALUES ('216', 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', '780');
INSERT INTO `country` VALUES ('217', 'TN', 'TUNISIA', 'Tunisia', 'TUN', '788');
INSERT INTO `country` VALUES ('218', 'TR', 'TURKEY', 'Turkey', 'TUR', '792');
INSERT INTO `country` VALUES ('219', 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', '795');
INSERT INTO `country` VALUES ('220', 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', '796');
INSERT INTO `country` VALUES ('221', 'TV', 'TUVALU', 'Tuvalu', 'TUV', '798');
INSERT INTO `country` VALUES ('222', 'UG', 'UGANDA', 'Uganda', 'UGA', '800');
INSERT INTO `country` VALUES ('223', 'UA', 'UKRAINE', 'Ukraine', 'UKR', '804');
INSERT INTO `country` VALUES ('224', 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', '784');
INSERT INTO `country` VALUES ('225', 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', '826');
INSERT INTO `country` VALUES ('226', 'US', 'UNITED STATES', 'United States', 'USA', '840');
INSERT INTO `country` VALUES ('227', 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', null, null);
INSERT INTO `country` VALUES ('228', 'UY', 'URUGUAY', 'Uruguay', 'URY', '858');
INSERT INTO `country` VALUES ('229', 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', '860');
INSERT INTO `country` VALUES ('230', 'VU', 'VANUATU', 'Vanuatu', 'VUT', '548');
INSERT INTO `country` VALUES ('231', 'VE', 'VENEZUELA', 'Venezuela', 'VEN', '862');
INSERT INTO `country` VALUES ('232', 'VN', 'VIET NAM', 'Viet Nam', 'VNM', '704');
INSERT INTO `country` VALUES ('233', 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', '92');
INSERT INTO `country` VALUES ('234', 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', '850');
INSERT INTO `country` VALUES ('235', 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', '876');
INSERT INTO `country` VALUES ('236', 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', '732');
INSERT INTO `country` VALUES ('237', 'YE', 'YEMEN', 'Yemen', 'YEM', '887');
INSERT INTO `country` VALUES ('238', 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', '894');
INSERT INTO `country` VALUES ('239', 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', '716');

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso_code` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES ('1', 'AFA', 'Afghan Afghani', '971');
INSERT INTO `currency` VALUES ('2', 'AWG', 'Aruban Florin', '533');
INSERT INTO `currency` VALUES ('3', 'AUD', 'Australian Dollars', '036');
INSERT INTO `currency` VALUES ('4', 'ARS', 'Argentine Pes', '03');
INSERT INTO `currency` VALUES ('5', 'AZN', 'Azerbaijanian Manat', '944');
INSERT INTO `currency` VALUES ('6', 'BSD', 'Bahamian Dollar', '044');
INSERT INTO `currency` VALUES ('7', 'BDT', 'Bangladeshi Taka', '050');
INSERT INTO `currency` VALUES ('8', 'BBD', 'Barbados Dollar', '052');
INSERT INTO `currency` VALUES ('9', 'BYR', 'Belarussian Rouble', '974');
INSERT INTO `currency` VALUES ('10', 'BOB', 'Bolivian Boliviano', '068');
INSERT INTO `currency` VALUES ('11', 'BRL', 'Brazilian Real', '986');
INSERT INTO `currency` VALUES ('12', 'GBP', 'British Pounds Sterling', '826');
INSERT INTO `currency` VALUES ('13', 'BGN', 'Bulgarian Lev', '975');
INSERT INTO `currency` VALUES ('14', 'KHR', 'Cambodia Riel', '116');
INSERT INTO `currency` VALUES ('15', 'CAD', 'Canadian Dollars', '124');
INSERT INTO `currency` VALUES ('16', 'KYD', 'Cayman Islands Dollar', '136');
INSERT INTO `currency` VALUES ('17', 'CLP', 'Chilean Peso', '152');
INSERT INTO `currency` VALUES ('18', 'CNY', 'Chinese Renminbi Yuan', '156');
INSERT INTO `currency` VALUES ('19', 'COP', 'Colombian Peso', '170');
INSERT INTO `currency` VALUES ('20', 'CRC', 'Costa Rican Colon', '188');
INSERT INTO `currency` VALUES ('21', 'HRK', 'Croatia Kuna', '191');
INSERT INTO `currency` VALUES ('22', 'CPY', 'Cypriot Pounds', '196');
INSERT INTO `currency` VALUES ('23', 'CZK', 'Czech Koruna', '203');
INSERT INTO `currency` VALUES ('24', 'DKK', 'Danish Krone', '208');
INSERT INTO `currency` VALUES ('25', 'DOP', 'Dominican Republic Peso', '214');
INSERT INTO `currency` VALUES ('26', 'XCD', 'East Caribbean Dollar', '951');
INSERT INTO `currency` VALUES ('27', 'EGP', 'Egyptian Pound', '818');
INSERT INTO `currency` VALUES ('28', 'ERN', 'Eritrean Nakfa', '232');
INSERT INTO `currency` VALUES ('29', 'EEK', 'Estonia Kroon', '233');
INSERT INTO `currency` VALUES ('30', 'EUR', 'Euro', '978');
INSERT INTO `currency` VALUES ('31', 'GEL', 'Georgian Lari', '981');
INSERT INTO `currency` VALUES ('32', 'GHC', 'Ghana Cedi', '288');
INSERT INTO `currency` VALUES ('33', 'GIP', 'Gibraltar Pound', '292');
INSERT INTO `currency` VALUES ('34', 'GTQ', 'Guatemala Quetzal', '320');
INSERT INTO `currency` VALUES ('35', 'HNL', 'Honduras Lempira', '340');
INSERT INTO `currency` VALUES ('36', 'HKD', 'Hong Kong Dollars', '344');
INSERT INTO `currency` VALUES ('37', 'HUF', 'Hungarian Forint', '348');
INSERT INTO `currency` VALUES ('38', 'ISK', 'Icelandic Krona', '352');
INSERT INTO `currency` VALUES ('39', 'INR', 'Indian Rupee', '356');
INSERT INTO `currency` VALUES ('40', 'IDR', 'Indonesia Rupiah', '360');
INSERT INTO `currency` VALUES ('41', 'ILS', 'Israel Shekel', '376');
INSERT INTO `currency` VALUES ('42', 'JMD', 'Jamaican Dollar', '388');
INSERT INTO `currency` VALUES ('43', 'JPY', 'Japanese yen', '392');
INSERT INTO `currency` VALUES ('44', 'KZT', 'Kazakhstan Tenge', '368');
INSERT INTO `currency` VALUES ('45', 'KES', 'Kenyan Shilling', '404');
INSERT INTO `currency` VALUES ('46', 'KWD', 'Kuwaiti Dinar', '414');
INSERT INTO `currency` VALUES ('47', 'LVL', 'Latvia Lat', '428');
INSERT INTO `currency` VALUES ('48', 'LBP', 'Lebanese Pound', '422');
INSERT INTO `currency` VALUES ('49', 'LTL', 'Lithuania Litas', '440');
INSERT INTO `currency` VALUES ('50', 'MOP', 'Macau Pataca', '446');
INSERT INTO `currency` VALUES ('51', 'MKD', 'Macedonian Denar', '807');
INSERT INTO `currency` VALUES ('52', 'MGA', 'Malagascy Ariary', '969');
INSERT INTO `currency` VALUES ('53', 'MYR', 'Malaysian Ringgit', '458');
INSERT INTO `currency` VALUES ('54', 'MTL', 'Maltese Lira', '470');
INSERT INTO `currency` VALUES ('55', 'BAM', 'Marka', '977');
INSERT INTO `currency` VALUES ('56', 'MUR', 'Mauritius Rupee', '480');
INSERT INTO `currency` VALUES ('57', 'MXN', 'Mexican Pesos', '484');
INSERT INTO `currency` VALUES ('58', 'MZM', 'Mozambique Metical', '508');
INSERT INTO `currency` VALUES ('59', 'NPR', 'Nepalese Rupee', '524');
INSERT INTO `currency` VALUES ('60', 'ANG', 'Netherlands Antilles Guilder', '532');
INSERT INTO `currency` VALUES ('61', 'TWD', 'New Taiwanese Dollars', '901');
INSERT INTO `currency` VALUES ('62', 'NZD', 'New Zealand Dollars', '554');
INSERT INTO `currency` VALUES ('63', 'NIO', 'Nicaragua Cordoba', '558');
INSERT INTO `currency` VALUES ('64', 'NGN', 'Nigeria Naira', '566');
INSERT INTO `currency` VALUES ('65', 'KPW', 'North Korean Won', '408');
INSERT INTO `currency` VALUES ('66', 'NOK', 'Norwegian Krone', '578');
INSERT INTO `currency` VALUES ('67', 'OMR', 'Omani Riyal', '512');
INSERT INTO `currency` VALUES ('68', 'PKR', 'Pakistani Rupee', '586');
INSERT INTO `currency` VALUES ('69', 'PYG', 'Paraguay Guarani', '600');
INSERT INTO `currency` VALUES ('70', 'PEN', 'Peru New Sol', '604');
INSERT INTO `currency` VALUES ('71', 'PHP', 'Philippine Pesos', '608');
INSERT INTO `currency` VALUES ('72', 'QAR', 'Qatari Riyal', '634');
INSERT INTO `currency` VALUES ('73', 'RON', 'Romanian New Leu', '946');
INSERT INTO `currency` VALUES ('74', 'RUB', 'Russian Federation Ruble', '643');
INSERT INTO `currency` VALUES ('75', 'SAR', 'Saudi Riyal', '682');
INSERT INTO `currency` VALUES ('76', 'CSD', 'Serbian Dinar', '891');
INSERT INTO `currency` VALUES ('77', 'SCR', 'Seychelles Rupee', '690');
INSERT INTO `currency` VALUES ('78', 'SGD', 'Singapore Dollars', '702');
INSERT INTO `currency` VALUES ('79', 'SKK', 'Slovak Koruna', '703');
INSERT INTO `currency` VALUES ('80', 'SIT', 'Slovenia Tolar', '705');
INSERT INTO `currency` VALUES ('81', 'ZAR', 'South African Rand', '710');
INSERT INTO `currency` VALUES ('82', 'KRW', 'South Korean Won', '410');
INSERT INTO `currency` VALUES ('83', 'LKR', 'Sri Lankan Rupee', '144');
INSERT INTO `currency` VALUES ('84', 'SRD', 'Surinam Dollar', '968');
INSERT INTO `currency` VALUES ('85', 'SEK', 'Swedish Krona', '752');
INSERT INTO `currency` VALUES ('86', 'CHF', 'Swiss Francs', '756');
INSERT INTO `currency` VALUES ('87', 'TZS', 'Tanzanian Shilling', '834');
INSERT INTO `currency` VALUES ('88', 'THB', 'Thai Baht', '764');
INSERT INTO `currency` VALUES ('89', 'TTD', 'Trinidad and Tobago Dollar', '780');
INSERT INTO `currency` VALUES ('90', 'TRY', 'Turkish New Lira', '949');
INSERT INTO `currency` VALUES ('91', 'AED', 'UAE Dirham', '784');
INSERT INTO `currency` VALUES ('92', 'USD', 'United States Dollars', '840');
INSERT INTO `currency` VALUES ('93', 'UGX', 'Ugandian Shilling', '800');
INSERT INTO `currency` VALUES ('94', 'UAH', 'Ukraine Hryvna', '980');
INSERT INTO `currency` VALUES ('95', 'UYU', 'Uruguayan Peso', '858');
INSERT INTO `currency` VALUES ('96', 'UZS', 'Uzbekistani Som', '860');
INSERT INTO `currency` VALUES ('97', 'VEB', 'Venezuela Bolivar', '862');
INSERT INTO `currency` VALUES ('98', 'VND', 'Vietnam Dong', '704');
INSERT INTO `currency` VALUES ('99', 'AMK', 'Zambian Kwacha', '894');
INSERT INTO `currency` VALUES ('100', 'ZWD', 'Zimbabwe Dollar', '716');

-- ----------------------------
-- Table structure for `transaction`
-- ----------------------------
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `transaction_type_id` tinyint(2) NOT NULL,
  `account_id` int(11) NOT NULL,
  `transfer_transaction_id` int(11) DEFAULT NULL,
  `to_account_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `account_balance` double(11,2) NOT NULL,
  `transaction_status_id` tinyint(2) NOT NULL DEFAULT '0',
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_transaction_status_1` (`transaction_status_id`),
  KEY `fk_transaction_type_1` (`transaction_type_id`),
  KEY `created_at` (`created_at`) USING BTREE,
  KEY `deleted` (`deleted`) USING BTREE,
  KEY `fk_transaction_category_1` (`category_id`),
  KEY `fk_transaction_transfer_1` (`transfer_transaction_id`),
  KEY `fk_transaction_account_1` (`account_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`),
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`transaction_status_id`) REFERENCES `transaction_status` (`id`),
  CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`transfer_transaction_id`) REFERENCES `transaction` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `transaction_ibfk_5` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of transaction
-- ----------------------------

-- ----------------------------
-- Table structure for `transaction_status`
-- ----------------------------
DROP TABLE IF EXISTS `transaction_status`;
CREATE TABLE `transaction_status` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of transaction_status
-- ----------------------------
INSERT INTO `transaction_status` VALUES ('1', 'Cleared');
INSERT INTO `transaction_status` VALUES ('2', 'Pending');

-- ----------------------------
-- Table structure for `transaction_type`
-- ----------------------------
DROP TABLE IF EXISTS `transaction_type`;
CREATE TABLE `transaction_type` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of transaction_type
-- ----------------------------
INSERT INTO `transaction_type` VALUES ('1', 'Expense');
INSERT INTO `transaction_type` VALUES ('2', 'Income');
INSERT INTO `transaction_type` VALUES ('3', 'Transfer');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `default_currency_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `activation_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_address` (`email_address`),
  KEY `status` (`status`),
  KEY `fk_user_country_1` (`country_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user_login`
-- ----------------------------
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_login
-- ----------------------------
