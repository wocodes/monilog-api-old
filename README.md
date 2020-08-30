# Monilog - API
**Version**: v0.0.1<br>
**Created**: 27 Aug. 2020<br>
**Last Modified**: 27 Aug. 2020


<p>This is the official API for Monilog Finance Manager. 
Monilog enables you monitor/log your finances on daily, weekly, monthly and annual basis. 
The path to wealth entails proper finance management.</p>


### Contributors
Below is a list of our development team on Monilog - Api

<ul>
<li>William Odiomonafe - Developer</li>
</ul>


### Available Endpoints/Todos
<p>Below is a list of feature endpoints on Monilog Api. All endpoints can be accessed/consumed via 
our base URL https://api-monilog.schoolly.co</p>
<p>You are free to send feature requests to william.odiomonafe@gmail.com</p>
<br>

- [x] Register

```
Endpoint: /api/user/register
Method: POST
Data {
        "name": "John Doe",
        "email": "johndoe@gmail",
        "password": "password"
     }
```
---
- [x] Login

```
Endpoint: /api/user/login
Method: POST
Data {
        "email": "johndoe@gmail",
        "password": "password"
     }
```
---
- [x] Get all user's expenses (auth)
```
Endpoint: /api/expenses/
Method: GET
Auth: Requires Bearer Access token
```
---
- [x] Get user's expenses for today (auth)
```
Endpoint: /api/expenses/today
Method: GET
Auth: Requires Bearer Access token
```
---
- [x] Get user's expenses for the current month (auth)
```
Endpoint: /api/expenses/current-month
Method: GET
Auth: Requires Bearer Access token
```
---
- [x] Get user's expenses for a specific month and year (auth)
```
Endpoint: /api/expenses/{year}/{month}
Method: GET
Auth: Requires Bearer Access token
```
---
- [x] Get user's expenses for a specific year (auth)
```
Endpoint: /api/expenses/{year}
Method: GET
Auth: Requires Bearer Access token
```

