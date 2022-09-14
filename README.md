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

    2.1 - Method exceptions in controller to put exception class
          and HTTP code inside an array avoiding use of try catch in
          every controller.

    2.2 - ApiController to register exceptions from controllers.

    2.3 - ApiExceptionsHttpStatusCodeMapping to fill exceptions array
          and get status code from exception classes.

    2.4 - ApiExceptionListener listening kernel exception events to build
          a response with exception message and code.

**3 - Mailing:**

    3.1 - Using mailer symfony service to send mail when user is registered
          (can be checked in local using mailtrap application to test mailing)
