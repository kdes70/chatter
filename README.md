# chatter
Laravel vue.js RealTime chat messeges

## Installation
```php
composer require kdes70/chatter
```


Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Kdes70\Chatter\ChatterServiceProvider::class,
```

```php 
php artisan vendor:publish --provider="Kdes70\Chatter\ChatterServiceProvider"
```

And 
```php 
php artisan migrate

change APP_URL in .env
```

Install the JavaScript dependencies:
```javascript
    npm install
```


In `resources/assets/js/app.js` file:

```vuejs
 import VueChatScroll from 'vue-chat-scroll';
 import VueTimeago from 'vue-timeago';
 
 Vue.use(VueChatScroll);
 Vue.component('chat-room' , require('./components/Chatter/ChatRoom.vue'));
 
 Vue.use(VueTimeago, {
     name: 'timeago', // component name, `timeago` by default
     locale: 'en-US',
     locales: {
         'en-US': require('vue-timeago/locales/en-US.json')
     }
 })
```

Run `npm run dev` to recompile your assets.
=======

