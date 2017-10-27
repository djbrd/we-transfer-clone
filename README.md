# WeTransfer Clone

This application is a simple clone of [WeTransfer](https://wetransfer.com/) using [Filestack](https://www.filestack.com/) to enable the transfer of image files with password protection.

It was written to complete [this task description](docs/aufgabe.md).

## Requirements

- PHP 5.6+
- MySQL

## Installing

To install an existing Symfony Application, you can follow the [guidelines in the official documentation](https://symfony.com/doc/current/setup.html#installing-an-existing-symfony-application).

You will also require an account at [Filestack](https://www.filestack.com/) with security enabled.

To initialise the database, run the following two commands (from the project's root directory):
```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

To run the application locally for testing, you can use the web server provided by Symfony, which can be run with the following command:

```
bin/console server:run
```

## Known problems and possible improvements
- When a file is retrieved, it is displayed in the browser instead of being downloaded by the browser into a downloads folder, which I would prefer. This latter behaviour could be enabled with a couple of lines of code, but then the form would not refreshed in browser. This could be done with a little JavaScript when the form is submitted.
- I don't like storing the mimetype of the shared file in the database, as this information is available in the Filelink when the file is retrieved from Filestack. However, I wanted to encapsulate the Filestack related code in the FilestackManager class, and to avoid saving the file on the server before returning it to the client. Instead of just returning the file content from FilestackManager, I should probably return an object in which both the content and the mimetype are represented.
- Routes at which passwords are submitted should only be available via a secure connection. This has been configured, but not tested.
- Limiting the size of uploaded files
- Unit tests and behaviour tests
- A menu on the client and some styling
- Because an upload and download may take a little time, some indication on the client that a request is being processed would be nice.
- Rewrite as a reusable bundle
