# Isoros - framework

Dit project omvat de ontwikkeling van een simpel backend framework voor een webapplicatie die fungeert als een
tentamenvolgsysteem, vergelijkbaar met Osiris. Het framework is ontwikkeld aan de hand van de theoretische kennis die
besproken is tijdens de hoorcolleges en omvat verschillende componenten die aansluiten bij de onderwerpen die behandeld
zijn.

Het functionele ontwerp beschrijft de context en doelstellingen van de webapplicatie en omvat de requirements en use
cases die nodig zijn voor het implementeren van de applicatie. Ook worden de verschillende pagina's van de webapplicatie
beschreven en worden de gemaakte keuzes steekhoudend onderbouwd met geschikte methodes.

De webapplicatie maakt het voor studenten mogelijk om zich in te schrijven voor tentamens en hun cijfers en tentamens 
te bekijken. Beheerders hebben toegang tot alle onderdelen van het systeem en kunnen deze beheren.

Voor de webapplicatie zijn mogelijk externe diensten nodig, zoals e-maildiensten. Er kan ervoor gekozen worden om te
koppelen met echte diensten, mogelijk in een developmentmodus, of om mocks te gebruiken die zich naar de code gedragen
als echte diensten, maar de dienst niet daadwerkelijk implementeren.


## Installatie

1. Kloon de repository: `git clone https://github.com/yourusername/yourproject.git`
2. Ga naar de projectmap: `cd yourproject`
3. Installeer de afhankelijkheden: `composer install`
4. Maak een database (SQL) aan en configureer de databaseverbinding in `config/database.php`

## Gebruik

Start de ingebouwde PHP-webserver:

php -S localhost:8000 -t public

Open het project in je browser: `http://localhost:8000`


## Licentie

Dit project is gemaakt door Jaron Oun en Dorien Kuperus.
