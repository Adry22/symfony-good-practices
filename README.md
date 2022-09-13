Symfony good practices
==========
Symfony app with some examples of good practices

***

**App structure:**

- Docker
- Nginx
- MySQL
- Symfony project

***

**1 - Project initilization:**
    
    1.1 - Customize namespace from App (default) to Universe

    1.2 - Creating database and load fixtures

**2 - Handling errors:**

    1.1 - Method exceptions in controller to put exception class
          and HTTP code inside an array.

    1.2 - ApiController to register exceptions from controllers.

    1.3 - ApiExceptionsHttpStatusCodeMapping to fill exceptions array
          and get status code from exception classes.

    1.4 - ApiExceptionListener listening kernel exception events to build
          a response with exception message and code.
