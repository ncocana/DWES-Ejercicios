# Gates

- [Gates](#gates)
  - [Proyecto base](#proyecto-base)
  - [Usuarios de prueba](#usuarios-de-prueba)
  - [Ubicación de las Gates](#ubicación-de-las-gates)
  - [Tipos de autorización](#tipos-de-autorización)
    - [v-auth-2.1](#v-auth-21)
    - [v-auth-2.2](#v-auth-22)
    - [v-auth-2.3](#v-auth-23)

## Proyecto base

Para realizar esta práctica se uso de base el proyecto de Chirper. Accede a la página Chirps en la página de navegación para ver los chirps.   

## Usuarios de prueba

Super: `super@cifpfbmoll.eu`   
Admin: `admin@cifpfbmoll.eu`   
Propietario: `propietario@cifpfbmoll.eu`   
Invitado: `invitado@cifpfbmoll.eu`   

Todos comparten la misma contraseña: `password`

## Ubicación de las Gates

Las Gates están definidas en el archivo `app/Providers/AuthServiceProvider.php`. 

Las autorizaciones se realizan en `app/Http/Controllers/ChirpController.php`.

## Tipos de autorización

Hay 3 Gates: `create-chirp`, `edit-chirp`, y `delete-chirp`.   

- `create-chirp`: Puedes crear un chirp si tu rol no es "Invitado".
- `edit-chirp` y `delete-chirp`: Puedes editar y borrar un chirp si tu rol no es "Invitado".
- Si tu rol es "Super", puedes realizar todas estas acciones independientemente de si el chirp te pertenece o no.

### v-auth-2.1

Se encuentra comentado en el archivo `app/Http/Requests/ChirpRequest.php`.

### v-auth-2.2

Se encuentra en el archivo `app/Http/Requests/ChirpRequest.php` y `app/Http/Controllers/ChirpController.php`.

### v-auth-2.3

Se puede ver en `resources/views/chirps/index.blade.php`.
