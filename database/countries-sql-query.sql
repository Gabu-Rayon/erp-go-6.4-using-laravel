DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alpha2_code` char(2) DEFAULT NULL,
  `alpha3_code` char(3) DEFAULT NULL,
  `numeric_code` char(3) DEFAULT NULL,
  `iso31662_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--------------------------GIT HUB REPO -----------------------------------------
------https://gist.github.com/jgornick/766738/63c1d6325b53cbafe37a3aa2523448a1d8505e3a-----------------------------------------
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Afghanistan', 'AF', 'AFG', '004', 'ISO 3166-2:AF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Åland Islands', 'AX', 'ALA', '248', 'ISO 3166-2:AX');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Albania', 'AL', 'ALB', '008', 'ISO 3166-2:AL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Algeria', 'DZ', 'DZA', '012', 'ISO 3166-2:DZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('American Samoa', 'AS', 'ASM', '016', 'ISO 3166-2:AS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Andorra', 'AD', 'AND', '020', 'ISO 3166-2:AD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Angola', 'AO', 'AGO', '024', 'ISO 3166-2:AO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Anguilla', 'AI', 'AIA', '660', 'ISO 3166-2:AI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Antarctica', 'AQ', 'ATA', '010', 'ISO 3166-2:AQ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Antigua and Barbuda', 'AG', 'ATG', '028', 'ISO 3166-2:AG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Argentina', 'AR', 'ARG', '032', 'ISO 3166-2:AR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Armenia', 'AM', 'ARM', '051', 'ISO 3166-2:AM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Aruba', 'AW', 'ABW', '533', 'ISO 3166-2:AW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Australia', 'AU', 'AUS', '036', 'ISO 3166-2:AU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Austria', 'AT', 'AUT', '040', 'ISO 3166-2:AT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Azerbaijan', 'AZ', 'AZE', '031', 'ISO 3166-2:AZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bahamas', 'BS', 'BHS', '044', 'ISO 3166-2:BS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bahrain', 'BH', 'BHR', '048', 'ISO 3166-2:BH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bangladesh', 'BD', 'BGD', '050', 'ISO 3166-2:BD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Barbados', 'BB', 'BRB', '052', 'ISO 3166-2:BB');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Belarus', 'BY', 'BLR', '112', 'ISO 3166-2:BY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Belgium', 'BE', 'BEL', '056', 'ISO 3166-2:BE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Belize', 'BZ', 'BLZ', '084', 'ISO 3166-2:BZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Benin', 'BJ', 'BEN', '204', 'ISO 3166-2:BJ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bermuda', 'BM', 'BMU', '060', 'ISO 3166-2:BM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bhutan', 'BT', 'BTN', '064', 'ISO 3166-2:BT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bolivia, Plurinational State of', 'BO', 'BOL', '068', 'ISO 3166-2:BO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bonaire, Saint Eustatius and Saba', 'BQ', 'BES', '535', 'ISO 3166-2:BQ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bosnia and Herzegovina', 'BA', 'BIH', '070', 'ISO 3166-2:BA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Botswana', 'BW', 'BWA', '072', 'ISO 3166-2:BW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bouvet Island', 'BV', 'BVT', '074', 'ISO 3166-2:BV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Brazil', 'BR', 'BRA', '076', 'ISO 3166-2:BR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('British Indian Ocean Territory', 'IO', 'IOT', '086', 'ISO 3166-2:IO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Brunei Darussalam', 'BN', 'BRN', '096', 'ISO 3166-2:BN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Bulgaria', 'BG', 'BGR', '100', 'ISO 3166-2:BG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Burkina Faso', 'BF', 'BFA', '854', 'ISO 3166-2:BF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Burundi', 'BI', 'BDI', '108', 'ISO 3166-2:BI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cambodia', 'KH', 'KHM', '116', 'ISO 3166-2:KH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cameroon', 'CM', 'CMR', '120', 'ISO 3166-2:CM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Canada', 'CA', 'CAN', '124', 'ISO 3166-2:CA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cape Verde', 'CV', 'CPV', '132', 'ISO 3166-2:CV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cayman Islands', 'KY', 'CYM', '136', 'ISO 3166-2:KY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Central African Republic', 'CF', 'CAF', '140', 'ISO 3166-2:CF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Chad', 'TD', 'TCD', '148', 'ISO 3166-2:TD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Chile', 'CL', 'CHL', '152', 'ISO 3166-2:CL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('China', 'CN', 'CHN', '156', 'ISO 3166-2:CN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Christmas Island', 'CX', 'CXR', '162', 'ISO 3166-2:CX');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cocos (Keeling) Islands', 'CC', 'CCK', '166', 'ISO 3166-2:CC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Colombia', 'CO', 'COL', '170', 'ISO 3166-2:CO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Comoros', 'KM', 'COM', '174', 'ISO 3166-2:KM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Congo', 'CG', 'COG', '178', 'ISO 3166-2:CG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Congo, the Democratic Republic of the', 'CD', 'COD', '180', 'ISO 3166-2:CD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cook Islands', 'CK', 'COK', '184', 'ISO 3166-2:CK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Costa Rica', 'CR', 'CRI', '188', 'ISO 3166-2:CR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Côte d\'Ivoire', 'CI', 'CIV', '384', 'ISO 3166-2:CI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Croatia', 'HR', 'HRV', '191', 'ISO 3166-2:HR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cuba', 'CU', 'CUB', '192', 'ISO 3166-2:CU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Curaçao', 'CW', 'CUW', '531', 'ISO 3166-2:CW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Cyprus', 'CY', 'CYP', '196', 'ISO 3166-2:CY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Czech Republic', 'CZ', 'CZE', '203', 'ISO 3166-2:CZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Denmark', 'DK', 'DNK', '208', 'ISO 3166-2:DK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Djibouti', 'DJ', 'DJI', '262', 'ISO 3166-2:DJ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Dominica', 'DM', 'DMA', '212', 'ISO 3166-2:DM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Dominican Republic', 'DO', 'DOM', '214', 'ISO 3166-2:DO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Ecuador', 'EC', 'ECU', '218', 'ISO 3166-2:EC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Egypt', 'EG', 'EGY', '818', 'ISO 3166-2:EG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('El Salvador', 'SV', 'SLV', '222', 'ISO 3166-2:SV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Equatorial Guinea', 'GQ', 'GNQ', '226', 'ISO 3166-2:GQ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Eritrea', 'ER', 'ERI', '232', 'ISO 3166-2:ER');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Estonia', 'EE', 'EST', '233', 'ISO 3166-2:EE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Ethiopia', 'ET', 'ETH', '231', 'ISO 3166-2:ET');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Falkland Islands (Malvinas)', 'FK', 'FLK', '238', 'ISO 3166-2:FK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Faroe Islands', 'FO', 'FRO', '234', 'ISO 3166-2:FO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Fiji', 'FJ', 'FJI', '242', 'ISO 3166-2:FJ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Finland', 'FI', 'FIN', '246', 'ISO 3166-2:FI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('France', 'FR', 'FRA', '250', 'ISO 3166-2:FR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('French Guiana', 'GF', 'GUF', '254', 'ISO 3166-2:GF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('French Polynesia', 'PF', 'PYF', '258', 'ISO 3166-2:PF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('French Southern Territories', 'TF', 'ATF', '260', 'ISO 3166-2:TF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Gabon', 'GA', 'GAB', '266', 'ISO 3166-2:GA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Gambia', 'GM', 'GMB', '270', 'ISO 3166-2:GM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Georgia', 'GE', 'GEO', '268', 'ISO 3166-2:GE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Germany', 'DE', 'DEU', '276', 'ISO 3166-2:DE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Ghana', 'GH', 'GHA', '288', 'ISO 3166-2:GH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Gibraltar', 'GI', 'GIB', '292', 'ISO 3166-2:GI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Greece', 'GR', 'GRC', '300', 'ISO 3166-2:GR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Greenland', 'GL', 'GRL', '304', 'ISO 3166-2:GL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Grenada', 'GD', 'GRD', '308', 'ISO 3166-2:GD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guadeloupe', 'GP', 'GLP', '312', 'ISO 3166-2:GP');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guam', 'GU', 'GUM', '316', 'ISO 3166-2:GU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guatemala', 'GT', 'GTM', '320', 'ISO 3166-2:GT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guernsey', 'GG', 'GGY', '831', 'ISO 3166-2:GG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guinea', 'GN', 'GIN', '324', 'ISO 3166-2:GN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guinea-Bissau', 'GW', 'GNB', '624', 'ISO 3166-2:GW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Guyana', 'GY', 'GUY', '328', 'ISO 3166-2:GY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Haiti', 'HT', 'HTI', '332', 'ISO 3166-2:HT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Heard Island and McDonald Islands', 'HM', 'HMD', '334', 'ISO 3166-2:HM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Holy See (Vatican City State)', 'VA', 'VAT', '336', 'ISO 3166-2:VA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Honduras', 'HN', 'HND', '340', 'ISO 3166-2:HN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Hong Kong', 'HK', 'HKG', '344', 'ISO 3166-2:HK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Hungary', 'HU', 'HUN', '348', 'ISO 3166-2:HU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Iceland', 'IS', 'ISL', '352', 'ISO 3166-2:IS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('India', 'IN', 'IND', '356', 'ISO 3166-2:IN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Indonesia', 'ID', 'IDN', '360', 'ISO 3166-2:ID');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Iran, Islamic Republic of', 'IR', 'IRN', '364', 'ISO 3166-2:IR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Iraq', 'IQ', 'IRQ', '368', 'ISO 3166-2:IQ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Ireland', 'IE', 'IRL', '372', 'ISO 3166-2:IE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Isle of Man', 'IM', 'IMN', '833', 'ISO 3166-2:IM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Israel', 'IL', 'ISR', '376', 'ISO 3166-2:IL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Italy', 'IT', 'ITA', '380', 'ISO 3166-2:IT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Jamaica', 'JM', 'JAM', '388', 'ISO 3166-2:JM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Japan', 'JP', 'JPN', '392', 'ISO 3166-2:JP');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Jersey', 'JE', 'JEY', '832', 'ISO 3166-2:JE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Jordan', 'JO', 'JOR', '400', 'ISO 3166-2:JO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Kazakhstan', 'KZ', 'KAZ', '398', 'ISO 3166-2:KZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Kenya', 'KE', 'KEN', '404', 'ISO 3166-2:KE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Kiribati', 'KI', 'KIR', '296', 'ISO 3166-2:KI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Korea, Democratic People\'s Republic of', 'KP', 'PRK', '408', 'ISO 3166-2:KP');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Korea, Republic of', 'KR', 'KOR', '410', 'ISO 3166-2:KR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Kuwait', 'KW', 'KWT', '414', 'ISO 3166-2:KW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Kyrgyzstan', 'KG', 'KGZ', '417', 'ISO 3166-2:KG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Lao People\'s Democratic Republic', 'LA', 'LAO', '418', 'ISO 3166-2:LA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Latvia', 'LV', 'LVA', '428', 'ISO 3166-2:LV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Lebanon', 'LB', 'LBN', '422', 'ISO 3166-2:LB');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Lesotho', 'LS', 'LSO', '426', 'ISO 3166-2:LS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Liberia', 'LR', 'LBR', '430', 'ISO 3166-2:LR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Libyan Arab Jamahiriya', 'LY', 'LBY', '434', 'ISO 3166-2:LY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Liechtenstein', 'LI', 'LIE', '438', 'ISO 3166-2:LI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Lithuania', 'LT', 'LTU', '440', 'ISO 3166-2:LT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Luxembourg', 'LU', 'LUX', '442', 'ISO 3166-2:LU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Macao', 'MO', 'MAC', '446', 'ISO 3166-2:MO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Macedonia, the former Yugoslav Republic of', 'MK', 'MKD', '807', 'ISO 3166-2:MK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Madagascar', 'MG', 'MDG', '450', 'ISO 3166-2:MG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Malawi', 'MW', 'MWI', '454', 'ISO 3166-2:MW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Malaysia', 'MY', 'MYS', '458', 'ISO 3166-2:MY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Maldives', 'MV', 'MDV', '462', 'ISO 3166-2:MV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mali', 'ML', 'MLI', '466', 'ISO 3166-2:ML');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Malta', 'MT', 'MLT', '470', 'ISO 3166-2:MT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Marshall Islands', 'MH', 'MHL', '584', 'ISO 3166-2:MH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Martinique', 'MQ', 'MTQ', '474', 'ISO 3166-2:MQ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mauritania', 'MR', 'MRT', '478', 'ISO 3166-2:MR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mauritius', 'MU', 'MUS', '480', 'ISO 3166-2:MU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mayotte', 'YT', 'MYT', '175', 'ISO 3166-2:YT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mexico', 'MX', 'MEX', '484', 'ISO 3166-2:MX');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Micronesia, Federated States of', 'FM', 'FSM', '583', 'ISO 3166-2:FM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Moldova, Republic of', 'MD', 'MDA', '498', 'ISO 3166-2:MD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Monaco', 'MC', 'MCO', '492', 'ISO 3166-2:MC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mongolia', 'MN', 'MNG', '496', 'ISO 3166-2:MN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Montenegro', 'ME', 'MNE', '499', 'ISO 3166-2:ME');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Montserrat', 'MS', 'MSR', '500', 'ISO 3166-2:MS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Morocco', 'MA', 'MAR', '504', 'ISO 3166-2:MA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Mozambique', 'MZ', 'MOZ', '508', 'ISO 3166-2:MZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Myanmar', 'MM', 'MMR', '104', 'ISO 3166-2:MM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Namibia', 'NA', 'NAM', '516', 'ISO 3166-2:NA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Nauru', 'NR', 'NRU', '520', 'ISO 3166-2:NR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Nepal', 'NP', 'NPL', '524', 'ISO 3166-2:NP');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Netherlands', 'NL', 'NLD', '528', 'ISO 3166-2:NL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('New Caledonia', 'NC', 'NCL', '540', 'ISO 3166-2:NC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('New Zealand', 'NZ', 'NZL', '554', 'ISO 3166-2:NZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Nicaragua', 'NI', 'NIC', '558', 'ISO 3166-2:NI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Niger', 'NE', 'NER', '562', 'ISO 3166-2:NE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Nigeria', 'NG', 'NGA', '566', 'ISO 3166-2:NG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Niue', 'NU', 'NIU', '570', 'ISO 3166-2:NU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Norfolk Island', 'NF', 'NFK', '574', 'ISO 3166-2:NF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Northern Mariana Islands', 'MP', 'MNP', '580', 'ISO 3166-2:MP');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Norway', 'NO', 'NOR', '578', 'ISO 3166-2:NO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Oman', 'OM', 'OMN', '512', 'ISO 3166-2:OM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Pakistan', 'PK', 'PAK', '586', 'ISO 3166-2:PK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Palau', 'PW', 'PLW', '585', 'ISO 3166-2:PW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Palestinian Territory, Occupied', 'PS', 'PSE', '275', 'ISO 3166-2:PS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Panama', 'PA', 'PAN', '591', 'ISO 3166-2:PA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Papua New Guinea', 'PG', 'PNG', '598', 'ISO 3166-2:PG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Paraguay', 'PY', 'PRY', '600', 'ISO 3166-2:PY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Peru', 'PE', 'PER', '604', 'ISO 3166-2:PE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Philippines', 'PH', 'PHL', '608', 'ISO 3166-2:PH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Pitcairn', 'PN', 'PCN', '612', 'ISO 3166-2:PN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Poland', 'PL', 'POL', '616', 'ISO 3166-2:PL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Portugal', 'PT', 'PRT', '620', 'ISO 3166-2:PT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Puerto Rico', 'PR', 'PRI', '630', 'ISO 3166-2:PR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Qatar', 'QA', 'QAT', '634', 'ISO 3166-2:QA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Réunion', 'RE', 'REU', '638', 'ISO 3166-2:RE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Romania', 'RO', 'ROU', '642', 'ISO 3166-2:RO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Russian Federation', 'RU', 'RUS', '643', 'ISO 3166-2:RU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Rwanda', 'RW', 'RWA', '646', 'ISO 3166-2:RW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Barthélemy', 'BL', 'BLM', '652', 'ISO 3166-2:BL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', '654', 'ISO 3166-2:SH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Kitts and Nevis', 'KN', 'KNA', '659', 'ISO 3166-2:KN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Lucia', 'LC', 'LCA', '662', 'ISO 3166-2:LC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Martin (French part)', 'MF', 'MAF', '663', 'ISO 3166-2:MF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Pierre and Miquelon', 'PM', 'SPM', '666', 'ISO 3166-2:PM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saint Vincent and the Grenadines', 'VC', 'VCT', '670', 'ISO 3166-2:VC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Samoa', 'WS', 'WSM', '882', 'ISO 3166-2:WS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('San Marino', 'SM', 'SMR', '674', 'ISO 3166-2:SM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sao Tome and Principe', 'ST', 'STP', '678', 'ISO 3166-2:ST');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Saudi Arabia', 'SA', 'SAU', '682', 'ISO 3166-2:SA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Senegal', 'SN', 'SEN', '686', 'ISO 3166-2:SN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Serbia', 'RS', 'SRB', '688', 'ISO 3166-2:RS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Seychelles', 'SC', 'SYC', '690', 'ISO 3166-2:SC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sierra Leone', 'SL', 'SLE', '694', 'ISO 3166-2:SL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Singapore', 'SG', 'SGP', '702', 'ISO 3166-2:SG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sint Maarten (Dutch part)', 'SX', 'SXM', '534', 'ISO 3166-2:SX');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Slovakia', 'SK', 'SVK', '703', 'ISO 3166-2:SK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Slovenia', 'SI', 'SVN', '705', 'ISO 3166-2:SI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Solomon Islands', 'SB', 'SLB', '090', 'ISO 3166-2:SB');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Somalia', 'SO', 'SOM', '706', 'ISO 3166-2:SO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('South Africa', 'ZA', 'ZAF', '710', 'ISO 3166-2:ZA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('South Georgia and the South Sandwich Islands', 'GS', 'SGS', '239', 'ISO 3166-2:GS');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Spain', 'ES', 'ESP', '724', 'ISO 3166-2:ES');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sri Lanka', 'LK', 'LKA', '144', 'ISO 3166-2:LK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sudan', 'SD', 'SDN', '736', 'ISO 3166-2:SD');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Suriname', 'SR', 'SUR', '740', 'ISO 3166-2:SR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Svalbard and Jan Mayen', 'SJ', 'SJM', '744', 'ISO 3166-2:SJ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Swaziland', 'SZ', 'SWZ', '748', 'ISO 3166-2:SZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Sweden', 'SE', 'SWE', '752', 'ISO 3166-2:SE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Switzerland', 'CH', 'CHE', '756', 'ISO 3166-2:CH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Syrian Arab Republic', 'SY', 'SYR', '760', 'ISO 3166-2:SY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Taiwan, Province of China', 'TW', 'TWN', '158', 'ISO 3166-2:TW');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tajikistan', 'TJ', 'TJK', '762', 'ISO 3166-2:TJ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tanzania, United Republic of', 'TZ', 'TZA', '834', 'ISO 3166-2:TZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Thailand', 'TH', 'THA', '764', 'ISO 3166-2:TH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Timor-Leste', 'TL', 'TLS', '626', 'ISO 3166-2:TL');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Togo', 'TG', 'TGO', '768', 'ISO 3166-2:TG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tokelau', 'TK', 'TKL', '772', 'ISO 3166-2:TK');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tonga', 'TO', 'TON', '776', 'ISO 3166-2:TO');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Trinidad and Tobago', 'TT', 'TTO', '780', 'ISO 3166-2:TT');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tunisia', 'TN', 'TUN', '788', 'ISO 3166-2:TN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Turkey', 'TR', 'TUR', '792', 'ISO 3166-2:TR');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Turkmenistan', 'TM', 'TKM', '795', 'ISO 3166-2:TM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Turks and Caicos Islands', 'TC', 'TCA', '796', 'ISO 3166-2:TC');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Tuvalu', 'TV', 'TUV', '798', 'ISO 3166-2:TV');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Uganda', 'UG', 'UGA', '800', 'ISO 3166-2:UG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Ukraine', 'UA', 'UKR', '804', 'ISO 3166-2:UA');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('United Arab Emirates', 'AE', 'ARE', '784', 'ISO 3166-2:AE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('United Kingdom', 'GB', 'GBR', '826', 'ISO 3166-2:GB');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('United States', 'US', 'USA', '840', 'ISO 3166-2:US');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('United States Minor Outlying Islands', 'UM', 'UMI', '581', 'ISO 3166-2:UM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Uruguay', 'UY', 'URY', '858', 'ISO 3166-2:UY');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Uzbekistan', 'UZ', 'UZB', '860', 'ISO 3166-2:UZ');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Vanuatu', 'VU', 'VUT', '548', 'ISO 3166-2:VU');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Venezuela, Bolivarian Republic of', 'VE', 'VEN', '862', 'ISO 3166-2:VE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Viet Nam', 'VN', 'VNM', '704', 'ISO 3166-2:VN');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Virgin Islands, British', 'VG', 'VGB', '092', 'ISO 3166-2:VG');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Virgin Islands, U.S.', 'VI', 'VIR', '850', 'ISO 3166-2:VI');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Wallis and Futuna', 'WF', 'WLF', '876', 'ISO 3166-2:WF');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Western Sahara', 'EH', 'ESH', '732', 'ISO 3166-2:EH');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Yemen', 'YE', 'YEM', '887', 'ISO 3166-2:YE');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Zambia', 'ZM', 'ZMB', '894', 'ISO 3166-2:ZM');
INSERT INTO countries (name, alpha2_code, alpha3_code, numeric_code, iso31662_code) VALUES ('Zimbabwe', 'ZW', 'ZWE', '716', 'ISO 3166-2:ZW');