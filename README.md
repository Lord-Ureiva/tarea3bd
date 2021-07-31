# Tarea 3 Entrega 3
# Grupo 3 Dream Team Science Innotavors
![](img/Dream%20Team%20Logo.png)

## Integrantes:

<center>

| Nombre | Rol |
| ------ | --- |
|**Marco Espinoza**  |**201973074-6** |
|**Juan Mira**       |**201973055-k** |
|**Javier Peralta**  |**201973019-3** |

</center>

Consideraciones:
- Para todas las tablas del CRUD, se crearon 2 rutas con el metodo GET, una la cual saca todos los datos, y otra la cual saca un dato en especifico que se le pase por ruta de la forma /api/"Nombre Tabla"/id/
- Para las tablas que tienen 2 primary key's para poder poder usar los metodos GET para un dato especifico, PUSH, PUT, DELETE, se debe usar de la forma  /api/"Nombre Tabla"/pk1/pk2/
- Tanto Primary key's como fechas en las tablas se generan de forma automatica, las PK se generan a partir de la ultima agregada, y fechas con la hora actual en que se ejecuta el metodo.
- Todas las consultas pedidas se encuentras implementadas en un mismo archivo en el que se encuentra la funcion que lo ejecuta, junto a la funcion de la ruta que realiza y pide lo necesario para ejecutar de forma correcta la consulta pedida.
- En caso de que una de las consutas requiera de algun valor para ser ejecutada este se pasa a traves de la direccion de la api de la forma num_consulta/<valor_requerido>
- Solo se puede acceder a las secciones de la API si se ha iniciado sesion, en caso contrario si se trata de acceder a fuerza bruta a cualquier seccion ya sea del CRUD o consultas se redireccionará automaticamente hacia la pagina principal (index.html)
- Existe un archvo llamado "paises_get_list.php" el cual fue creado para autorellenar los formularios de seleccion de pais con lso paises e id's que se encuentren disponibles en la base de datos, a diferencia de la Tarea 2 en donde la relacion nombre/pais está puesta en bruto.
-Se ocuparon BluePrints para poder modularizar los archivos, funciones y clases de la API.
-Se ocupó cURL para hacer los llamados a la api desde los archivos PHP correspondientes.

Suposiciones:
-Se supone que a la hora de querer editar un valor como el precio de alguna moneda, o algun usuario, las fechas no se editaran debido a que es la que se ingresa cuando se realizo el guardado de la fila por lo que no es un dato accesible para editar.

