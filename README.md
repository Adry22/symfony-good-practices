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

**1 - Project initilization**
    
    1.1 - Customize namespace from App (default) to Universe

    1.2 - Creating database and load fixtures

**2 - Handling errors**

    2.1 - Method exceptions in controller to put exception class
          and HTTP code inside an array avoiding use of try catch in
          every controller

    2.2 - ApiController to register exceptions from controllers

    2.3 - ApiExceptionsHttpStatusCodeMapping to fill exceptions array
          and get status code from exception classes

    2.4 - ApiExceptionListener listening kernel exception events to build
          a response with exception message and code

**3 - Mailing**

    3.1 - Using mailer symfony service to send mail when user is registered
          (can be checked in local using mailtrap application to test mailing)

**4 - Testing**

    4.1 - Unit

        4.1.1 - BaseWebTestCase to purge test database at the end of each test

    4.2 - Functional

        4.2.1 - BaseWebApiTestCase

    4.3 - End to end (Behat and Mink)

        4.3.1 - behat.yml with extensions and suites
        4.3.2 - ApiContext
        4.3.3 - Features created to being tested
        
**5 - Authentication**

    5.1 - Lexik JWT Bundle to authenticate
    
    5.2 - Hashing user password

**6 - Logging**

    6.1 - Monolog Bundle
    
    6.2 - Custom channel main_log

**7 - Command and Query bus**

    7.1 - Tactician bundle
    
    7.2 - Tactician doctrine (rollback in case of fail)

**8 - Serialization**

    8.1 - FOSRestBundle

    8.2 - JMSSerializerBundle

**9 - Reports**
    
    9.1 - Formatter to format data

    9.2 - Writer to write file

    9.3 - Types
        
        9.3.1 - Xlsx with PhpOffice\PhpSpreadsheet
        9.3.2 - Docx with PhpOffice\PhpWord

**10 - Specification pattern**

    10.1 - Specification pattern to filter data (example in ListPlanet)

**11 - Makefile**

    11.1 - Makefile

**12 - Continuous integration**

    12.1 - CircleCI
    
        12.2 - CircleCI config file

**13 - OpenAPI documentation**

    13.1 - NelmioApiDocBundle

        13.1.1 - Added documentation using annotations in Controllers    
    
    13.2 - Added symfony_good_practices_swagger in docker-compose to run Swagger UI in local

    13.3 - Command in Makefile to generate OpenApi yaml in public/

**14 - Value object**
    
    14.1 - User Address