#!/bin/sh

apt-get update
# apt-get upgrade -y
apt-get install -y mariadb-server mariadb-client

# Crear la base de dades


# Configuració de MariaDB:
# - Permet connexions des de qualsevol host
# - Activa GROUP BY estricte
# - Permet || com a CONCAT (PIPES_AS_CONCAT)
# - No permet " com a delimitador de cadenes, només ' (ANSI_QUOTES)
echo *** Configura MariaDB ***
cp /vagrant/50-server.cnf /etc/mysql/mariadb.conf.d

# Crea l'usuari admin amb accés remot
echo *** Crea usuari ***
mysql << EOF
CREATE OR REPLACE USER admin@'%' IDENTIFIED BY '1234';
GRANT ALL ON *.* TO admin@'%';
EOF

systemctl restart mariadb