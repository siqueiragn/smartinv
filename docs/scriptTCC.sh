#!/bin/bash
echo "INICIOU"

#WALLPAPER

#cd ~/Imagens
#wget http://i.imgur.com/nFIY2yt.jpg
#mv nFIY2yt.jpg wp3.jpg
#xfconf-query -c xfce4-desktop -p /backdrop/screen0/monitor0/workspace0/last-image -s ~/Imagens/wp3.jpg

#REMOVENDO LIBREOFFICE

#apt-get remove --purge libreoffice* -y

#INSTALANDO WPS OFFICE

cd && wget -O wps-office.deb http://kdl.cc.ksosoft.com/wps-community/download/a21/wps-office_10.1.0.5672~a21_amd64.deb
sudo dpkg -i wps-office.deb
sudo apt-get -f install && rm wps-office.deb
wget -O web-office-fonts.deb http://kdl.cc.ksosoft.com/wps-community/download/fonts/wps-office-fonts_1.0_all.deb
sudo dpkg -i web-office-fonts.deb

cd ~/Downloads
wget https://ufpr.dl.sourceforge.net/project/dia-installer/dia/0.97.2/dia_0.97.2-5_i386.deb

sudo dpkg *.deb

sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys BBEBDCB318AD50EC6865090613B00F1FD2C19886
echo deb http://repository.spotify.com stable non-free | sudo tee /etc/apt/sources.list.d/spotify.list
sudo apt-get update 
sudo apt-get install spotify-client -y
sudo apt-get install pgadmin3 -y




