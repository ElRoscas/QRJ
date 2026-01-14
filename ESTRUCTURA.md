
//MENU INICIAL 1
index.php

// LOGINS 3
login.php
registre.php
recover_pwd.php

MENU-PHP 6
 OPCIONS:
    1.VEURE PERF/GEST USUARI 5
    2.GESTIONAR CONVIDATS
    3.LLISTA ESDVN
    4.CREAR ESDVN
    5.LLEGIR QR 2

// VEURE ESDV, CREAR/MOD ESDV
gestio-usuaris.php
list-esdv.php
view-esdv.php/$id_esd -> versio admin
create-esdv.php #admin
edit-esdv.php/$id_esd #admin

// QR
CreateQR.js
DescargarQR.js
ReadQR.php #worker

//PERFILS
view_user.php

 OPCIONS:
    1.VEURE PERF/GEST USUARI 5
    2.GESTIONAR CONVIDATS
    3.LLISTA ESDVN
    4.CREAR ESDVN
    5.LLEGIR QR 2

- MENU // LOGIN REGISTRE -> index.php

index->login->menu

index->registre->menu

menu->1|2|3|4|5

1
#ADMIN->gestio-usuaris.php
#Worker !PERM
#User->view_myuser.php
2
#ADMIN->gestio-usuaris.php
#Worker->gestio-usuaris.php
#User !PERM

3
#ADMIN->List-esdvn.php->create-esdv.php #admin edit-esdv.php/$id_esd #admin
#Worker !PERM
#User->List-esdvn.php->view-esdvn.php

4
#ADMIN->create-esdv.php

menu->view_myuser.php
menu->index
