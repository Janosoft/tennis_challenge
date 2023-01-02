# tennis_challenge
Challenge para Geopagos

DESARROLLO:

* Se creará una app utilizando el framework Symfony. Vale aclarar que será la primera app creada con ese framework
* Como base de datos se utilizará Mysql/MariaDB
* Se utilizará el repositorio tennis_challenge desde el inicio, para poder contar con el registro total de cambios
* Se utilizará como IDE Visual Studio Code

ACLARACIONES:

* Los Jugadores contarán con los atributos: Nombre, Fuerza, Velocidad, Reacción. Y la Habilidad será calculada con el promedio de los valores según el Torneo (Másculino: Fuerza, Velocidad -- Femenino: Reacción)
* El resultado de los Enfrentamientos/Partidos dependerá de la Habilidad de los Jugadores, teniendo un "potenciador" de suerte(0-10) que aplicará solo a uno de ellos.
* En caso de empate se declarará ganador a aquel que posea el potenciador.

NOTAS DE DESARROLLO:

* Se debería quitar .env de git pero por cuestiones de agilidad en el desarrollo no lo voy a hacer
* Se utilizará FakerPHP para generar valores al azar en los atributos del jugador que faltaran
* Los datos se guardarán en la BD si y solo si funcionó todo correctamente. Es por ello que en los games, los homeplayer_id y awayplayer_id siempre van a ser consecutivos

BASE DE DATOS:

TournamentType --* Tournament --* Stages --* Games *-- Players
