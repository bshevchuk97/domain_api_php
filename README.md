# Domain API

Provides simple a functionality of saving adding certain domains for specific users in order to block their
accessibility. It's important to acknowledge that this API gives any response in a JSON format.

## Routes

There are a handful of available routes and their respective REST methods:
- /register - a route to create a new user record in system;
- /login - a route to login an existing user and give him a new session token;
- /domains - returns a list of registered domains for current user;
- /domain/ (GET) - returns information on requested domain of a current user;
- /domain/ (POST) - adds new domains for a current user;
- /domain/ (PUT) - activates requested domain for a current user;
- /domain/ (DELETE) - deactivates requested domain for a current user.

Next table contains basic necessary technical information on how to refer to Domain API routes.

__! NOTE - User's password should not be openly transferred! Send a md5-hashed password string !__

| Route | Method | Headers |Body (JSON)|
|:-----:|:------:|:----:|:---:|
| /register | POST |none|{"username": [username], "password_hash": [password hash]}|
|/login|POST|none|{"username": [username], "password_hash": [password hash]}|
|/domains|GET|Bearer:[token]|none|
|/domain/{id}|GET|Bearer:[token]|none|
|/domain/|POST|Bearer:[token]|{"name": [name]}|
|/domain/{id}|PUT|Bearer:[token]|none|
|/domain/{id}|DELETE|Bearer:[token]|none|

In order to use routes of this API other than /register and /login you must specify a http header "Authorization: Bearer:[ your_session_token_goes_here ]". There should not be any spaces between a "Bearer" keyword and your actual session token. Session token is retrieved as a response on a successful login attempt.

## Errors

There are some common errors which may occur during usage of this API:
- User already exists on register attempt;
- User not found on login attempt;
- Session token has expired - it was created more than 4 hours ago;
- Session token nonexistent - it was deleted due to expiration or was not created at all;
- Requested domain not found for user;
- Requested domain already active/inactive on an activation/deactivation attempt.

