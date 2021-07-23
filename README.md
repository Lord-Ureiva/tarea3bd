# Tarea 3 Entrega 1
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
