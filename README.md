# tennis_challenge
Challenge realizado en Symfony

## Se desea modelar el comportamiento de un torneo de tenis ##
* La modalidad del torneo es por eliminación directa (1)
* Puede asumir por simplicidad que la cantidad de jugadores es potencia de 2.
* El torneo puede ser Femenino o Masculino
* Cada jugador tiene un nombre y un nivel de habilidad (entre 0 y 100)
* En un enfrentamiento entre dos jugadores influyen el nivel de habilidad y la suerte para
decidir al ganador del mismo. Es su decisión de diseño de qué forma incide la suerte en
este enfrentamiento.
* En el torneo masculino, se deben considerar la fuerza y la velocidad de desplazamiento
como parámetros adicionales al momento de calcular al ganador.
* En el torneo femenino, se debe considerar el tiempo de reacción como un parámetro
adicional al momento de calcular al ganador.
* No existen los empates
* Se requiere que a partir de una lista de jugadores se simule el torneo y se obtenga
como output al ganador del mismo.
* Se recomienda realizar la solución en su IDE preferido.
* Se valorarán las buenas prácticas de Programación Orientada a Objetos.
* Puede definir por su parte cualquier cuestión que considere que no es aclarada. Puede
agregar las aclaraciones que considere en la entrega del ejercicio
* Cualquier extra que aporte será bienvenido
* Se prefiere el modelado en capas o arquitecturas limpias (Clean Architecture)
* Se prefiere la entrega de la solución mediante un sistema de versionado
(github/bitbucket/etc)

(1) La eliminación directa, es un sistema en torneos que consiste en que el perdedor de un
encuentro queda inmediatamente eliminado de la competición, mientras que el ganador
avanza a la siguiente fase. Se van jugando rondas y en cada una de ellas se elimina la
mitad de participantes hasta dejar un único competidor que se corona como campeón.

## ACLARACIONES Y/O DECISIONES TOMADAS ##

* Los Jugadores contarán con los atributos: Nombre, Fuerza, Velocidad, Reacción. Y la Habilidad será calculada con el promedio de los valores según el Torneo (Másculino: Fuerza, Velocidad -- Femenino: Reacción)
* El resultado de los Enfrentamientos/Partidos dependerá de la Habilidad de los Jugadores, teniendo un "potenciador" de suerte(0-10) que aplicará solo a uno de ellos
* En caso de empate se declarará ganador a aquel que posea el potenciador
* La Base de Datos solamente se utilizará para almacenar los resultados. Esto permite que los jugadores que ya se encuentren guardados no participen, (sin querer), en próximos torneos.

## BASE DE DATOS ##

TournamentType --* Tournament --* Stages --* Games *-- Players

* (*) Hay doble relación entre Games y Players (homeplayer y awardplayer)

## CARACTERISTICAS ##

* Se creará una app utilizando el framework Symfony 6. Vale aclarar que será mi primer app creada con este framework
* Como base de datos se utilizará Mysql/MariaDB
* Se utilizará el repositorio tennis_challenge desde el inicio, para poder contar con el registro total de cambios
* Se utilizará como IDE Visual Studio Code
* Posee una sección visual en la home del sitio (/) que utiliza Bootstrap, de forma básica ya que no quise dedicarle mucho tiempo pero si hacerla funcional.
* Posee otra sección como API (/api/), (también accesible desde la parte visual), desde la cual se pueden obtener jsons o crear un torneo.

## NOTAS DE DESARROLLO ##

* Se debería quitar .env de git pero por cuestiones de agilidad en el desarrollo no lo voy a hacer
* Se utilizará FakerPHP para generar valores al azar en los atributos del jugador que faltaran
* Los datos se guardarán en la BD si y solo si funcionó todo correctamente. Es por ello que en los games, los homeplayer_id y awayplayer_id siempre van a ser consecutivos

## USO DEL SITIO ##
* El sitio cuenta con un HOME y desde allí se puede navegar por todas las opciones disponibles, entre ellas la posibilidad de jugar/crear un torneo desde un JSON.

## EJECUCIÓN DESDE LA CONSOLA ##
* Es posible ejecutar el test 'testATournamentCanBePlayed', el cual simulará el torneo, e imprimirá el string 'EL GANADOR FUE: NOMBRE_JUGADOR'

## EJECUCIÓN EN TEST ##
* Es posible ejecutar un Fixture y verificar el funcionamiento en una base de datos _test utilizando el comando 'php bin/console --env=test doctrine:fixtures:load'

## USO DE LA API ##
* Es posible crear un torneo realizando un POST a /tournament con un JSON en el Request Body

## MODELO DE JSON A UTILIZAR PARA CREAR UN TORNEO ##
{
  "date": "2023-03-15",
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

## INSTALACIÓN ##
* Se incluye .env para mayor facilidad
* Está configurado para utilizar servidor de base de datos Mysql estandar (usé la última versión de xampp) en el puerto 3306

* git clone git@github.com:Janosoft/tennis_challenge.git
* composer install
* php bin\console doctrine:database:create
* php bin\console doctrine:schema:update --force
* php bin/console --env=dev doctrine:fixtures:load

* (OPCIONAL ENTORNO DE TEST)
* php bin/console --env=test doctrine:database:create
* php bin/console --env=test doctrine:schema:create
* php bin/console --env=test doctrine:fixtures:load
* (OPCIONAL ENTORNO DE TEST)

* symfony serve

## AUTOR ##
Alejandro Martín Lodes
