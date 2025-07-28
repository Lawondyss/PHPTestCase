Vytvoreno v DeveloperHub

PHPTestCase
=============
* sada nastroju pro testovani aplikaci v PHP
* doporucuji PHPTestCase pouzit jako submodul

Instalace PHPTestCase
-----------------------
* klonovani externiho repozitare
    $ git submodule add http://github.com/Lawondyss/PHPTestCase.git libs/PHPTestCase
* v rootu projektu se vytvori soubor .gitmodules, ktery predstavuje konfig. soubor se
  zpracovanim mapovani mezi URL repozitare a lokalnim adresarem PHPTestCase
* hostingovy projekt je nyni povysen na "super projekt"
* pri klonovani je sice ziskan .gitmodules, ale ne jeho obsah
    * $ git submodule init   # inicializuje lokalni konfiguracni soubor
    * $ git submodule update # stahne podmoduly
* ve skeletonu v adresarich unit a selen maji readme ukazkove tridy testu

Nastaveni
==========
* obsah adresare skeleton/ prekopirujte do rootu Vase aplikace
* ziskate:
    * phpunit.xml    - konfigurace PHPUnit
    * tests/
        * case/
            * selen/   - adresar pro selen testy
            * unit/    - adresar pro integracni a jednotkove testy
        * coverage/       - adresar pro coverage report
        * libs/           - adresar pro tridy tretich stran ci jejich upravy (pouzite pouze v testech)
    * runTests        - skript pro spusteni PHPUnit a NetteTestCase

Spousteni integracnich a jednotkovych testu
===========================================
* z rootu projektu spustte:
    $ ./runTests
    * bez parametru se spusti vsechny testy
    * s parametrem --group unit se spusti jen unit testy
* pokud pouzivate pre-commit hook, automaticky se spuštěji testy pouze ve skupine unit

Spousteni testu pred provedenim prikazu git commit
==================================================
* nakopirujte soubor libs/PHPTestCase/git-hooks/pre-commit (nebo pre-commit.php) do .git/hooks/
* muzete nastavit, ktere testy se maji spustit pri commitu
* muzete nastavit cestu k PHP
* pri git commit:
    * spusti PHPUnit
    * pokud projdou testy, commit pokracuje
    * pokud ne, commit se zastavi

Poznamky k nastaveni phpunit.xml
================================
* listeners
    * Application_Test_TestTimesListener - po odkomentovani hlida max. 2s delku behu jednoho testu
