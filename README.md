# CONCEPTBPO
CRUD PHPH PURO
1. informaciòn general
#PRUEBA_TECNICA_CONCEPT_BPO

Proyecto web full stack para la gestión de productos financieros. Permite crear, listar, eliminar y visualizar la descripción de cada producto. 


##Requisitos

- PHP 7.4+
- MySQL/MariaDB
- XAMPP / Apache (recomendado)
- Navegadoes Chrome, Firefox, Edge, preferiblemente firefox.

---
2.
##Instalación

3.
sql
CREATE DATABASE productos_db;

USE productos_db;

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL,
  rentabilidad FLOAT NOT NULL,
  riesgo VARCHAR(100) NOT NULL
);
```
- varibles php para la conexión
private $host = "localhost";
private $db_name = "productos_db";
private $username = "root";
private $password = "";
```

4. Abrir XAMPP y activa Apache y MySQL activos.

5. ruta de acceso al back 
```
http://localhost/PRUEBA_TECNICA_CONCEPT_BPO/PUBLIC/index.php
```

6. acceso al front frontend:
   no usar live server
   abrir directamente el archivo `HTML/index.html` desde el navegador

---

7. Funcionalidades

Acción        | Descripción                                      

Crear          Formulario para agregar un nuevo producto        
Listar         Tabla dinámica que muestra todos los productos   
Detalles      Ver la descripción completa del producto         
Eliminar       Botón que borra el producto de forma permanente  
---

#Endpoints de la API

| Método | Ruta                                | Acción                  |
|--------|-------------------------------------|--------------------------|
| GET    | `/PUBLIC/index.php`                 | Obtener todos los productos |
| POST   | `/PUBLIC/index.php`                 | Crear un nuevo producto     |
| DELETE | `/PUBLIC/index.php?id=ID`           | Eliminar producto por ID    |

---



- Desarrollado por [Andrés Palencia]
- Prueba técnica para Concept BPO

---

Este proyecto es una prueba técnica
