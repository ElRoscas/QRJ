# QRJ BD

# *************************************************************************** #
# TAULES
# //////
# Usuaris
#  -ID (Correu) PK UNIQUE  FK a QRJ.Permisos*
#   y QRJ.Esdeveniments**
#  -Nom
#  -Telefon
#  -Contrasenya
# //////
# Permissos
#  -ID
#  -ID_USER* 
#  -Permissos [00000-11111]***
#       Els permissos son els seguents
#       Veure, Modificar, Crear, Escanejar, Inscriures
#       Guardem en varchar delimitant les entrades al rang***
# //////
# Esdeveniments
#  -ID
#  -ID_USER**
#  -Nom
#  -Descripcio
#  -Nº Invitats
#  -Nº VIPS
#  -Tipus
#
#
# *************************************************************************** #