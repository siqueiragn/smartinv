#!/bin/bash
#
# Versão 1.0.0: Deve estar no diretorio bin para ser global
#
# Marcio Bigolin, Setembro de 2017
#
sudo service apache2 stop
clear
if [ -f ".ready" ]
then
	echo "Pronto para iniciar o ambiente."
else
	echo "Parece que é nossa primeira execução vamos realizar algumas tarefas."
	echo "--------"
	echo "Se acontecer algum erro por aqui verifique se você tem o git devidamente instalado em seu computador."
	git submodule init
	git submodule update
	echo "Agora que você tem tudo pronto vou passar a bola para o Enyalius. "
        if which eny >/dev/null; then
            echo 'O enyalius está instalado na versão'
            eny --version
            echo 'Essa versão deve ser superior ou igual a' 
            grep '^# Versão ' "$0" | tail -1 | cut -d : -f 1 | tr -d \#
        else
            sudo cp core/enyalius /bin/eny
            sudo chmod +x /bin/eny
        fi
	eny -i
	echo "Pronto para iniciar o ambiente."
	touch .ready
fi
sudo docker run -e "WEBAPP_ROOT=public_html" -v $PWD:/app -e WEBAPP_USER_ID=$(id -u) -p 80:80 enyalius/dev:latest