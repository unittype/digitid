# **API**

Explore the API here hands-on.

This API supports a data response in JSON format.

You can view the definition of this API in OpenAPI Specification 2.0 format in this examples. 

Need a little help? Feel free to make a contact.

Prototype project to demonstrate GSA API Standards and API Documentation Template.

### Request `GET` required
```
https:// 200 : ok



```
### Response types:
* `200 : OK` 
* `404 : Not Found`
* `400 : Bad Request`

### Response `GET` `200 : OK`
``` 
  'ok' : true
  'result' : [
      username : string
      email : string
      firs_name : string
      last_name : string
      country : string
      date_of_birth : date
      avatar : string (base64_encode)   
      ]   
```
### Response `GET` `404 : Not Found` 
```
  'ok' : false
  'error' : 404
  'description' : 'Not Found'
```
### Response `GET` `400 : Bad Request`
```
  'ok' : false
  'error' : 400
  'description' : 'Bad Request'
```