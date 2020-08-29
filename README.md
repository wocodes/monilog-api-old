# Monilog - API
**Version**: v0.0.1<br>
**Created**: 27 Aug. 2020<br>
**Last Modified**: 27 Aug. 2020


<p>This is the official API for Monilog Finance Manager. 
Monilog enables you monitor/log your finances on daily, weekly, monthly and annual basis. 
The path to wealth entials proper finance management.</p>


### Contributors
Below is a list of our development team on Monilog - Api

<ul>
<li>William Odiomonafe - Developer</li>
</ul>


### Available Enpoints/Todos
<p>Below is a list of feature endpoints on Monilog Api. All enpoints can be accessed/consumed via 
our base URL https://api-monilog.schoolly.co</p>
<p>You are free to send feature requests to william.odiomonafe@gmail.com</p>
<br>
[x] Register <br>

```
Endpoint: /api/user/register
Method: POST
Data {
        "name": "John Doe",
        "email": "johndoe@gmail",
        "password": "password"
     }
```
[x] Login <br>

```
Endpoint: /api/user/login
Method: POST
Data {
        "email": "johndoe@gmail",
        "password": "password"
     }
```

