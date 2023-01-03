# tennis_challenge
Challenge para Geopagos

## ACLARACIONES Y/O DECISIONES TOMADAS ##

* Los Jugadores contarán con los atributos: Nombre, Fuerza, Velocidad, Reacción. Y la Habilidad será calculada con el promedio de los valores según el Torneo (Másculino: Fuerza, Velocidad -- Femenino: Reacción)
* El resultado de los Enfrentamientos/Partidos dependerá de la Habilidad de los Jugadores, teniendo un "potenciador" de suerte(0-10) que aplicará solo a uno de ellos
* En caso de empate se declarará ganador a aquel que posea el potenciador
* La Base de Datos solamente se utilizará para almacenar los resultados. Esto permite que los jugadores que ya se encuentren guardados no participen, (sin querer), en próximos torneos.

## BASE DE DATOS ##

TournamentType --* Tournament --* Stages --* Games *-- Players

* (*) Hay doble relación entre Games y Players (homeplayer y awardplayer)

## CARACTERISTICAS ##

* Se creará una app utilizando el framework Symfony. Vale aclarar que será la primera app creada con ese framework
* Como base de datos se utilizará Mysql/MariaDB
* Se utilizará el repositorio tennis_challenge desde el inicio, para poder contar con el registro total de cambios
* Se utilizará como IDE Visual Studio Code

## NOTAS DE DESARROLLO ##

* Se debería quitar .env de git pero por cuestiones de agilidad en el desarrollo no lo voy a hacer
* Se utilizará FakerPHP para generar valores al azar en los atributos del jugador que faltaran
* Los datos se guardarán en la BD si y solo si funcionó todo correctamente. Es por ello que en los games, los homeplayer_id y awayplayer_id siempre van a ser consecutivos

## USO DE LA API ##
* El sitio cuenta con un HOME y desde allí se puede navegar por todas las opciones disponibles, entre ellas la posibilidad de jugar/crear un torneo desde un JSON.

## MODELO DE JSON A UTILIZAR PARA CREAR UN TORNEO ##
{
  "tournament_type": {
    "title": "Mixto",
    "skills": [
      "strength",
      "reaction"
    ]
  },
  "players": [
    {
      "name": "Alejandro",
      "strength": 90,
      "speed": 85,
      "reaction": 90
    },
    {
      "name": "Andrea",
      "strength": 85,
      "speed": 90,
      "reaction": 90
    }
  ]
}

## EJECUCIÓN DESDE LA CONSOLA ##
* Es posible ejecutar el test 'testATournamentCanBePlayed', el cual simulará el torneo, e imprimirá el string 'EL GANADOR FUE: NOMBRE_JUGADOR'

## EJECUCIÓN EN TEST ##
* Es posible ejecutar un Fixture y verificar el funcionamiento en una base de datos _test utilizando el comando 'php bin/console --env=test doctrine:fixtures:load'

## AUTOR ##
Alejandro Martín Lodes