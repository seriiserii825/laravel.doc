#install
run composer require laravel/ui
run php artisan ui vue for just installing Vue.
run php artisan ui vue --auth for scaffolding out the auth views.
run npm install && npm run dev

# config
Add the following to your resources/js/app.js:

 window.Vue = require('vue');
 Vue.component('example-component', require('./components/ExampleComponent.vue').default);
 const app = new Vue({
   el: '#app',
 });

#create component
Create an ExampleComponent.vue in the resources/js/components directory

<template>
  <div>Hello World.</div>
</template>

<script>
  export default {
    mounted() {
      console.log("Example component mounted");
    }
  };
</script>
Add <script src="{{ asset('js/app.js') }}" defer></script> in the <head> section of your layout file (resources/views/layouts/app.blade.php)

Add id="app" to <body> or main <div> in your layout file (resources/views/layouts/app.blade.php)

Add <example-component /> to your view

Run npm run dev or npm run watch

Finally, open up the devtools, and in the console log you should see Example component mounted
