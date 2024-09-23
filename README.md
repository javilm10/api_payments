Este proyecto es una API REST desarrollada con **Symfony** que permite realizar cobros mediante **tarjeta** y **monedas**. 

- El endpoint para el **cobro con tarjeta** valida la tarjeta introducida y guarda las transacciones en una base de datos **MariaDB**.
- El endpoint para el **cobro con monedas** procesa la solicitud y devuelve una respuesta.

## Características

- **Cobro con tarjeta**: Valida los datos de la tarjeta y almacena las transacciones en una base de datos.
- **Cobro con monedas**: Procesa una solicitud de pago utilizando monedas.
- **Base de datos**: Utiliza **MariaDB** para almacenar las transacciones de pago.
- **Validación**: Valida los datos de la tarjeta de crédito (número, fecha de expiración, CVV, etc.).

## Requisitos

Antes de comenzar, asegúrate de tener instalados los siguientes componentes:

- **PHP** 7.4 o superior
- **Composer** para gestionar dependencias
- **MariaDB** para la base de datos
- **Symfony CLI** (opcional, pero recomendado)

## Instalación

1. Clona este repositorio en tu máquina local:

   ```bash
   git clone https://github.com/javilm10/api_payments.git
   ```

2. Dirígete a la carpeta del proyecto:

   ```bash
   cd api_payments
   ```

3. Instala las dependencias del proyecto utilizando **Composer**:

   ```bash
   composer install
   ```

4. Configura tu base de datos MariaDB en el archivo `.env`:

   ```bash
   DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/nombre_base_datos"
   ```

   Cambia `usuario`, `contraseña`, y `nombre_base_datos` por los valores correctos de tu entorno.

5. Ejecuta las migraciones de base de datos para crear las tablas necesarias:

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. Inicia el servidor de desarrollo de Symfony:

   ```bash
   symfony server:start
   ```

   O utilizando PHP directamente:

   ```bash
   php -S localhost:8000 -t public
   ```

## Endpoints

### 1. Cobro con tarjeta

- **Método**: `POST`
- **Ruta**: `/api/payment/card`
- **Descripción**: Valida los datos de la tarjeta de crédito y guarda la transacción en la base de datos.

#### Parámetros de la solicitud (JSON):

```json
{
  "numeroTarjeta": "1234567812345678",
  "currency": eur,
  "amount": 100.00
}
```

#### Respuesta exitosa:

- **Código**: `200 OK`
- **Cuerpo**:

```json
{
    "success": true
}
```

### 2. Cobro con monedas

- **Método**: `POST`
- **Ruta**: `/api/payment/cash`
- **Descripción**: Procesa el pago con monedas y devuelve una respuesta indicando el resultado.


#### Respuesta exitosa:

- **Código**: `200 OK`
- **Cuerpo**:

```json
{
    "success": true,
    "amount": 5473,
    "coin_types": {
        "5000": 1,
        "200": 2,
        "50": 1,
        "20": 1,
        "2": 1,
        "1": 1
    }
}
```

## Configuración de la Base de Datos

Este proyecto utiliza **MariaDB** para almacenar las transacciones de los pagos con tarjeta. Asegúrate de configurar correctamente tu conexión a la base de datos en el archivo `.env` y de ejecutar las migraciones correspondientes:

```bash
php bin/console doctrine:migrations:migrate
```

### Migraciones

Para generar nuevas migraciones basadas en cambios en tus entidades:

```bash
php bin/console doctrine:migrations:diff
```

Y para aplicarlas:

```bash
php bin/console doctrine:migrations:migrate
```

## Ejemplo de uso de la API

### Cobro con tarjeta

```bash
curl --location 'http://localhost:8000/api/payment/card' \
--header 'Content-Type: application/json' \
--data '{"amount": 14527, "currency": "eur", "card_num": 4111111111111111}'
```

### Cobro con monedas

```bash
curl --location 'http://localhost:8000/api/payment/cash' \
--header 'Content-Type: application/json' \
--data '{"amount": 14527, "currency": "eur", "coin_types": {"10000": 2}}'
```

## Licencia

Este proyecto está licenciado bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
```

### Explicación de las secciones clave:

1. **Instalación**: Instrucciones para configurar el entorno y ejecutar la aplicación.
2. **Endpoints**: Descripción de los dos endpoints, uno para cobro con tarjeta y otro para cobro con monedas.
3. **Base de datos**: Detalles sobre la configuración y uso de MariaDB.
4. **Ejemplo de uso**: Muestra cómo interactuar con los endpoints usando `curl`.
5. **Tests**: Incluye cómo ejecutar las pruebas del proyecto.

Este README cubre los aspectos esenciales para usar, instalar y contribuir al proyecto.