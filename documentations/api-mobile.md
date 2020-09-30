## API Documentation for Mobile App

This describes the resources that make up REST API for the GMT - Commercial management System

### Authentication
#### Login

##### Login Success
Request:

    POST: /api/auth/login
Body:

    {
		"email": "user@example.com",
		"password": "password",
		"device_name": "mobile"
	}


Response `200`

    token_code


##### Login failed with email required
Request:

    POST: /api/auth/login
Body:

    {
		"email": "",
		"password": "password",
		"device_name": "mobile"
	}


Response `422`

    {
	    "message":"The given data was invalid.",
	    "errors":{
		    "email":[
			    "The email field is required."
		    ]
	    }
    }

##### Login failed with wrong email
Request:

    POST: /api/auth/login
Body:

    {
		"email": "email_is_not_exists@example.com",
		"password": "password",
		"device_name": "mobile"
	}


Response `422`

    {
	    "message":"The given data was invalid.",
	    "errors":{
		    "email":[
			    "The selected email is invalid."
		    ]
	    }
    }
