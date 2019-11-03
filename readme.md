# Jobboard(Backend)

## What is Jobboard?
Is a Job Panel created for learning purpose using Laravel(in the backend) and Vue(in the frontend).

So as you might have noticed the project consists of two parts, the backend and the frontend, you can find the links to both repositories below:

-	[Frontend Jobboard]( https://github.com/benjaminvar/simple-jobboard-frontend.git)
-	[Backend Jobboard](https://github.com/benjaminvar/simple-jobboard-backend.git)

## How to run it?

### Clone the project
```
git clone https://github.com/benjaminvar/simple-jobboard-backend.git 
```

### Configure .env

#### Create .env
```
cp .env.example .env
```

#### Add email configuration
```
MAIL_HOST=<Your Mail Hostname>
MAIL_PORT=<Your Mail Host Port>
MAIL_USERNAME=<Your Mail Username>
MAIL_PASSWORD=<Your Mail Password>
MAIL_FROM_ADDRESS=<Your Mail From Address>
MAIL_FROM_NAME=<Your Mail From Name>
```

#### Configure API Credentials
```
CAPTCHA_SECRET=<Your Google Captcha API Client Secret>

FACEBOOK_CLIENT_ID=<Your Facebook API Client ID>
FACEBOOK_CLIENT_SECRET=<Your Facebook API Client Secret>
FACEBOOK_CLIENT_REDIRECT_URI=<Your Facebook API Client Redirect URI>

GOOGLE_CLIENT_ID=<Your Google API Client ID>
GOOGLE_CLIENT_SECRET=<Your Google API Client Redirect URI>
GOOGLE_CLIENT_REDIRECT_URI=<Your Google API Client Redirect URI>
```

#### Configure Site Owner Email and URL For Password Reset
```
RESET_PASSWORD_FRONTEND=<Your Frontend URL>

SITE_OWNER_EMAIL=<Your mail to receive contact page emails>
```

### Generate jwt secret
```
php artisan jwt:secret
```

### Create Storage Link
```
php artisan storage:link
```

### Install dependencies
```
composer install
```

### Deploy and enjoy it