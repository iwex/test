# Test task

**PHP 7.1**

Run `composer install` and `php artisan migrate` inside `receiver` and `sender` dirs.

Copy `.env.example` to `.env` and replace needed parameters

Sender:
```
ENCRYPTION_KEY= <enter some random string>
RECEIVER_URL= <enter receiver url>
AUTH_USERNAME= <enter desired username>
AUTH_PASSWORD= <and password>
```

Receiver:
```
ENCRYPTION_KEY= <repeat from Sender>
AUTH_USERNAME= <repeat from Sender>
AUTH_PASSWORD= <repeat from Sender>
```

Use.