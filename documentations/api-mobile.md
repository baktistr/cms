## API Documentation for Mobile App

This describes the resources that make up REST API for the GMT - Commercial management System

### Authentication
#### Login

**Login Success**

    POST: /api/auth/login
Parameters:
 - email `required`
 - password `required`
 - device_name `mobile`

Response:

    200: token_code
